<?php $this->set("title_for_layout", $post["Post"]["title"]);

echo $this->Session->flash(); ?>

<div id="infoPro" class="row">
  <section class="span12">
    <h1><?php echo $post['Project']['title'] ?></h1>
    <p><?php echo $post['Project']['description'] ?></p>
  </section>
</div>

<div id="post" class="row">
  <section id="self" class="span6">
    <?php echo $this->Html->image("posts/".$post["Post"]["image"], array("alt" => $post["Post"]["title"],"class" => "img-polaroid")); ?>
    <div id="navPro" class="row">
      <div id="prevPro" class="span3">
        <?php if(isset($neighbors["prev"])){ ?>
          <div class="row">
            <div class="span1">
              <?php echo $this->Html->link(
                $this->Html->image("posts/thumb-".substr($neighbors["prev"]["Post"]["image"],0,-4).".jpg", array("alt" => $neighbors["prev"]["Post"]["title"],"class" => "img-polaroid")),
                array("action" => "view", "controller" => "posts", $neighbors["prev"]["Post"]["id"]),
                array("escape" => false)
              ); ?>
            </div>
            <div class="span2">
              <?php echo $this->Html->link("Post précédent",array("action" => "view","controller" => "posts",$neighbors["prev"]["Post"]["id"])); ?>
            </div>
          </div>
        <?php } ?>
      </div>
      <div id="nextPro" class="span3">
        <?php if(isset($neighbors["next"])){ ?>
          <div class="row">
            <div class="span2">
              <?php echo $this->Html->link("Post suivant",array("action" => "view","controller" => "posts",$neighbors["prev"]["Post"]["id"])); ?>
            </div>
            <div class="span1">
              <?php echo $this->Html->link(
                $this->Html->image("posts/thumb-".substr($neighbors["next"]["Post"]["image"],0,-4).".jpg", array("alt" => $neighbors["next"]["Post"]["title"],"class" => "img-polaroid")),
                array("action" => "view", "controller" => "posts", $neighbors["next"]["Post"]["id"]),
                array("escape" => false)
              ); ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <section id="info" class="span4">
    <h1><?php echo $post['Post']['title'] ?></h1>
    <p class="whoPost">par <?php echo $this->Html->link($post["User"]["username"],array("action" => "view","controller" => "users",$post["User"]["id"])); ?></p>
    <p><?php echo $post['Post']['description'] ?></p>
    <ul class="unstyled">
      <?php if(AuthComponent::user("id")) {
        echo $this->Form->create("Like", array("url" => array("controller" => "likes", "action" => "like")));
        echo $this->Form->hidden("user_id",array(
          "value" => AuthComponent::user("id")
        ));
        echo $this->Form->hidden("post_id",array(
          "value" => $post["Post"]["id"]
        ));
        echo $this->Form->end();
        if($likeNot == false) { ?>        
          <a href="" onclick="event.preventDefault(); document.getElementById('LikeViewForm').submit();"><li><i class="icon-heart icon-large"></i> <?php echo count($post["Like"]) ?> likes</li></a>
        <?php } else { ?>
          <a class="liked" href="<?php echo $this->Html->url(array('controller' => 'likes', 'action' => 'unlike', '?' => array('user_id' => AuthComponent::user("id"), 'post_id' => $post['Post']['id']))) ?>"><li><i class="icon-heart icon-large"></i> <?php echo count($post["Like"]) ?> likes</li></a>
        <?php } ?>
      <?php } else { ?>
        <a href="" onclick="event.preventDefault();"><li><i class="icon-heart icon-large"></i> <?php echo count($post["Like"]) ?> likes</li></a>
      <?php } ?>
      <a href="#"><li><i class="icon-twitter icon-large"></i> Twitter</li></a>
      <a href="#"><li><i class="icon-facebook icon-large"></i> Facebook</li></a>
      <a href="#"><li><i class="icon-envelope-alt icon-large"></i> Mail</li></a>
      <?php if($post['Post']['user_id'] == AuthComponent::user("id")){ ?>
        <a href="<?php echo $this->Html->url(array('action' => 'edit', $post['Post']['id'])); ?>"><li><i class="icon-pencil icon-large"></i> Editer</li></a>
        <a href="<?php echo $this->Html->url(array('action' => 'delete', $post['Post']['id'])); ?>"><li><i class="icon-remove icon-large"></i> Supprimer</li></a>
      <?php } ?>
  </section>
  <section id="others" class="span2">
    <h2>Autre post de Axiol</h2>
    <div class="row">
      <?php for ($i = 0; $i <= 3; $i++) {
        if(isset($post["User"]["Post"][$i])){ ?>
          <div class="span1">
            <?php 
              echo $this->Html->link(
                $this->Html->image("posts/thumb-".substr($post["User"]["Post"][$i]["image"],0,-4).".jpg", array("alt" => $post["User"]["Post"][$i]["title"],"class" => "img-polaroid")),
                array("action" => "view", "controller" => "posts", $post["User"]["Post"][$i]["id"]),
                array("escape" => false)
              );
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
      <?php foreach ($post["Comment"] as $comment): ?>
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
      <?php endforeach; ?>
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