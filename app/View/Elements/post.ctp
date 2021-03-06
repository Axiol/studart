<div itemscope itemtype="http://schema.org/Article">
  <article class="post span3">
    <a class="commLink" href="<?php echo $this->Html->url(array('controller' => 'posts', 'action' => 'view', $post['id'], "#" => "comments"), true); ?>" title="Voir les commentaires de ce post">&nbsp;</a>
    <a class="likeLink" href="<?php echo $this->Html->url(array('controller' => 'posts', 'action' => 'whoLike', $post['id']), true); ?>" title="Voir les membres qui like ce post">&nbsp;</a>
    <a class="linkWrap" href="<?php echo $this->Html->url(array('controller' => 'posts', 'action' => 'view', $post['id']), true); ?>" title="Voir le post" itemprop="url">
      <div>
        <h1><span itemprop="name"><?php echo $post["title"]; ?></span></h1>
        <p>Un post de <span itemprop="creator"><?php echo $user["username"]; ?></span></p>
        <div class="btn-post">
          <?php $likeNot = false;
          if(AuthComponent::user("id")){
            foreach($likes as $like):
              if ($like['user_id'] == AuthComponent::user("id")){
                $likeNot = true;
              }
            endforeach;
            if($likeNot == true) { ?>
              <p class="love loveOK"><?php echo $post["like_count"]; ?></p>
            <?php } else { ?>
              <p class="love"><?php echo $post["like_count"]; ?></p>
            <?php }
          } else { ?>
            <p class="love"><?php echo $post["like_count"]; ?></p>
          <?php } ?>
          <p class="comment"><i class="icon-comment icon-white"></i></p>
          <meta itemprop="interactionCount" content="PostLikes:<?php echo $post['like_count']; ?>"/>
        </div>
      </div>
      <div class="previsu">
        <?php if ($post["image"] != "") { 
          echo $this->Html->image("posts/thumb-".substr($post["image"],0,-4).".jpg", array("alt" => $post["title"], "itemprop" => "image"));
        } elseif ($post["model"] != "") { ?>
          <img src="https://sketchfab.com/urls/<?php echo $post["model"] ?>/thumbnail_854.png" alt="<?php $post["title"] ?>" itemprop="image">
        <?php } ?>
        <div class="wrapTexte">
          <p><span itemprop="text"><?php echo $post["description"]; ?></span></p>
        </div>
      </div>
    </a>
  </article>
</div>
