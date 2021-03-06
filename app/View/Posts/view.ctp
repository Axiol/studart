<?php $this->set("title_for_layout", $post["Post"]["title"]);

echo $this->Session->flash(); ?>

<div id="infoPro" class="row">
  <section class="span12">
    <h1><?php echo $post['Project']['title'] ?></h1>
    <p><?php echo $post['Project']['description'] ?> (<?php echo $this->Html->link("Voir le projet",array("action" => "view","controller" => "projects",$post["Project"]["id"])); ?>)</p>
  </section>
</div>

<div id="post" class="row">
  <section id="self" class="span6">
    <h1 class="hide">Visuel de <?php echo $post["Post"]["title"] ?></h1>
    <?php if ($post["Post"]["image"] != "") { 
      echo $this->Html->image("posts/".$post["Post"]["image"], array("alt" => $post["Post"]["title"],"class" => "img-polaroid"));
    } elseif ($post["Post"]["model"] != "") { ?>
      <iframe frameborder="0" height="500" width="580" allowFullScreen webkitallowfullscreen="true"  mozallowfullscreen="true" src="https://sketchfab.com/embed/<?php echo $post["Post"]["model"] ?>?autostart=1&transparent=0&autospin=0.2&controls=0&watermark=1" class="full-frame"></iframe>
    <?php } ?>

    <div id="navPro" class="row">
      <div id="prevPro" class="span3">
        <?php if(isset($neighbors["prev"])){ ?>
          <a href="<?php echo $this->Html->url(array("action" => "view", "controller" => "posts", $neighbors["prev"]["Post"]["id"])); ?>" title="Voir le post précédent du projet">
            <div class="row">
              <div class="span1">
                <?php echo $this->Html->image("prePro.png", array(
                  "alt" => "Brownies",
                  "class" => "arrow visible-phone"
                ));
                if ($neighbors["prev"]["Post"]["image"] != "") { 
                  echo $this->Html->image("posts/thumb-".substr($neighbors["prev"]["Post"]["image"],0,-4).".jpg", array("alt" => $neighbors["prev"]["Post"]["title"],"class" => "img-polaroid"));
                } elseif ($neighbors["prev"]["Post"]["model"] != "") { ?>
                  <img src="https://sketchfab.com/urls/<?php echo $neighbors["prev"]["Post"]["model"] ?>/thumbnail_854.png" alt="<?php $neighbors["prev"]["Post"]["title"] ?>" class="img-polaroid dddNav">
                <?php } ?>
              </div>
              <div class="span2 hidden-phone">
                <p>Post précédent</p>
              </div>
            </div>
          </a>
        <?php } ?>
        &nbsp;
      </div>
      <div id="nextPro" class="span3">
        <?php if(isset($neighbors["next"])){ ?>
          <a href="<?php echo $this->Html->url(array("action" => "view", "controller" => "posts", $neighbors["next"]["Post"]["id"])); ?>" title="Voir le post suivant du projet">
            <div class="row">
              <div class="span2 hidden-phone">
                <p>Post suivant</p>
              </div>
              <div class="span1">
                <?php echo $this->Html->image("nePro.png", array(
                  "alt" => "Brownies",
                  "class" => "arrow visible-phone"
                ));
                if ($neighbors["next"]["Post"]["image"] != "") { 
                  echo $this->Html->image("posts/thumb-".substr($neighbors["next"]["Post"]["image"],0,-4).".jpg", array("alt" => $neighbors["next"]["Post"]["title"],"class" => "img-polaroid"));
                } elseif ($neighbors["next"]["Post"]["model"] != "") { ?>
                  <img src="https://sketchfab.com/urls/<?php echo $neighbors["next"]["Post"]["model"] ?>/thumbnail_854.png" alt="<?php $neighbors["next"]["Post"]["title"] ?>" class="img-polaroid dddNav">
                <?php } ?>
              </div>
            </div>
          </a>
        <?php } ?>
        &nbsp;
      </div>
    </div>
  </section>
  <div itemscope itemtype="http://schema.org/Article">
    <section id="info" class="span4">
      <h1><span itemprop="name"><?php echo $post['Post']['title'] ?></span></h1>
      <p class="whoPost">par <span itemprop="creator"><?php echo $this->Html->link($post["User"]["username"],array("action" => "view","controller" => "users",$post["User"]["id"])); ?></span></p>
      <p><span itemprop="text"><?php echo $post['Post']['description'] ?></span></p>
      <p id="tags">
        <?php foreach ($post["Tag"] as $tag): ?>
          <a class="tagsWrap" href="<?php echo $this->Html->url(array('action' => 'tag', $tag['name'])) ?>" title="Voir les autres posts ayant ce tag"><span class="tags"><?php echo $tag["name"]; ?></span></a>
        <?php endforeach; ?>
      </p>
      <ul class="unstyled">
        <?php if(AuthComponent::user("id") && AuthComponent::user("id") != $post['Post']["user_id"]) {
          if($likeNot == false) { ?>        
            <li class="liLike"><a class="likeCTRL" href="<?php echo $this->Html->url(array('controller' => 'likes', 'action' => 'like', $post['Post']['id'])) ?>" title="Liker ce post"><i class="icon-heart icon-large"></i> Je like ?</a><a class="likeCount" href="<?php echo $this->Html->url(array("controller" => "posts", "action" => "whoLike", $post["Post"]["id"])); ?>" title="Voir les membres qui like ce post"><?php echo "<i class='icon-group icon-large'></i> <span>".count($post["Like"])."</span> likes" ?></a></li>
            <li class="liUnlike hide"><a class="likeCTRL" href="<?php echo $this->Html->url(array('controller' => 'likes', 'action' => 'unlike', $post['Post']['id'])) ?>" title="Disliker ce post"><i class="icon-heart icon-large liked"></i> Je like !</a><a class="likeCount" href="<?php echo $this->Html->url(array("controller" => "posts", "action" => "whoLike", $post["Post"]["id"])); ?>" title="Voir les membres qui like ce post"><?php echo "<i class='icon-group icon-large'></i> <span>".count($post["Like"])."</span> likes" ?></a></li>
          <?php } else { ?>
            <li class="liUnlike"><a class="likeCTRL" href="<?php echo $this->Html->url(array('controller' => 'likes', 'action' => 'unlike', $post['Post']['id'])) ?>" title="Disliker ce post"><i class="icon-heart icon-large liked"></i> Je like !</a><a class="likeCount" href="<?php echo $this->Html->url(array("controller" => "posts", "action" => "whoLike", $post["Post"]["id"])); ?>" title="Voir les membres qui like ce post"><?php echo "<i class='icon-group icon-large'></i> <span>".count($post["Like"])."</span> likes" ?></a></li>
            <li class="liLike hide"><a class="likeCTRL" href="<?php echo $this->Html->url(array('controller' => 'likes', 'action' => 'like', $post['Post']['id'])) ?>" title="Liker ce post"><i class="icon-heart icon-large"></i> Je like ?</a><a class="likeCount" href="<?php echo $this->Html->url(array("controller" => "posts", "action" => "whoLike", $post["Post"]["id"])); ?>" title="Voir les membres qui like ce post"><?php echo "<i class='icon-group icon-large'></i> <span>".count($post["Like"])."</span> likes" ?></a></li>            
          <?php } ?>
        <?php } else { ?>
          <a href="<?php echo $this->Html->url(array("controller" => "posts", "action" => "whoLike", $post["Post"]["id"])); ?>" title="Voir les membres qui like ce post"><li><i class="icon-heart icon-large"></i> <?php echo count($post["Like"]) ?> likes</li></a>
        <?php } ?>
        <a title="Partager ce post sur Twitter" class="sharePopup" href="https://twitter.com/intent/tweet?url=<?php echo $this->Html->url(array('action' => 'view','controller' => 'posts',$post['Post']['id']),true); ?>&text=<?php echo $post['Post']['title'] ?>&via=StudartNews"><li><i class="icon-twitter icon-large"></i> Twitter</li></a>   
        <a title="Partager ce post sur Facebook" class="sharePopup" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(array('action' => 'view','controller' => 'posts',$post['Post']['id']),true); ?>"><li><i class="icon-facebook icon-large"></i> Facebook</li></a>
        <a title="Partager ce post sur Google+" class="sharePopup" href="https://plus.google.com/share?url=<?php echo $this->Html->url(array('action' => 'view','controller' => 'posts',$post['Post']['id']),true); ?>"><li><i class="icon-google-plus icon-large"></i> Google+</li></a>
        <a title="Partager ce post par mail"  href="mailto:?subject=<?php echo $post['Post']['title'] ?> sur StudArt&body=Viens jetter un oeil à mon post <?php echo $post['Post']['title'] ?> sur StudArt <?php echo $this->Html->url(array('action' => 'view','controller' => 'posts',$post['Post']['id']),true); ?>"><li><i class="icon-envelope-alt icon-large"></i> Mail</li></a>
        <?php if($post['Post']['user_id'] == AuthComponent::user("id") OR AuthComponent::user("admin") == 1){ ?>
          <a title="Editer ce post" href="<?php echo $this->Html->url(array('action' => 'edit', $post['Post']['id'])); ?>"><li><i class="icon-pencil icon-large"></i> Editer</li></a>
          <a title="Supprimer ce post" href="<?php echo $this->Html->url(array('action' => 'delete', $post['Post']['id'])); ?>" onclick="return confirm('Etes vous sûre de vouloir supprimer cet post ?');"><li><i class="icon-remove icon-large"></i> Supprimer</li></a>
        <?php } ?>
      </ul>
      <?php if ($neighbors["prev"]["Post"]["image"] != "") { 
        echo $this->Html->image("posts/thumb-".substr($neighbors["prev"]["Post"]["image"],0,-4).".jpg", array("alt" => $neighbors["prev"]["Post"]["title"],"class" => "img-polaroid hide", "itemprop" => "image"));
      } ?>
    </section>
  </div>
  <section id="others" class="span2 hidden-phone">
    <h2>Autre post de <?php echo $post["User"]["username"] ?></h2>
    <div class="row">
      <?php for ($i = 0; $i <= 3; $i++) {
        if(isset($post["User"]["Post"][$i])){ ?>
          <div class="span1">
            <?php 
              if ($post["User"]["Post"][$i]["image"] != "") {
                echo $this->Html->link(
                  $this->Html->image("posts/thumb-".substr($post["User"]["Post"][$i]["image"],0,-4).".jpg", array("alt" => $post["User"]["Post"][$i]["title"],"class" => "img-polaroid")),
                  array("action" => "view", "controller" => "posts", $post["User"]["Post"][$i]["id"]),
                  array("escape" => false)
                );
              } elseif ($post["User"]["Post"][$i]["model"] != "") {
                echo $this->Html->link(
                  $this->Html->image("https://sketchfab.com/urls/".$post['User']['Post'][$i]['model']."/thumbnail_854.png", array("alt" => $post["User"]["Post"][$i]["title"],"class" => "img-polaroid")),
                  array("action" => "view", "controller" => "posts", $post["User"]["Post"][$i]["id"]),
                  array("escape" => false)
                );
              }
            ?>
          </div>
        <?php }
      } ?>
    </div>
  </section>
</div>

<div class="row">
  <div class="span6">
    <section id="comments">
      <h1>Les commentaires</h1>
      <?php if(count($post["Comment"]) > 0) {
        foreach ($post["Comment"] as $comment): ?>
          <div class="comment">
            <?php
              $grav_email = $comment["User"]["mail"];
              $grav_size = 50;
              $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $grav_email ) ) ) . "?s=" . $grav_size;
              
              echo $this->Html->image($grav_url, array("alt" => "Avatar de ".$comment["User"]["username"]));
            ?>
            <blockquote>
              <p><?php echo $comment["content"] ?></p>
              <small>par <?php echo $this->Html->link($comment["User"]["username"],array("action" => "view","controller" => "users",$comment["User"]["id"])); ?></small>
            </blockquote>
          </div>
        <?php endforeach;
      } else { ?>
        <p class="noComment">Il n'y a aucun commentaire pour le moment.</p>
      <?php } ?>
    </section>
    
    <?php if(AuthComponent::user("id")): ?>
      <?php echo $this->Form->create("Comment",array("id" => "post-comment","action" => "add")); ?>
        <?php echo $this->Form->textarea("content",array("rows" => "4"));
              echo $this->Form->hidden("user_id",array("value" => AuthComponent::user("id")));
              echo $this->Form->hidden("post_id",array("value" => $post["Post"]["id"])); ?>
        <?php echo $this->Form->end(array("label" => "Poster un commentaire","class" => "btn")); ?>
    <?php endif; ?>
  </div>
</div>