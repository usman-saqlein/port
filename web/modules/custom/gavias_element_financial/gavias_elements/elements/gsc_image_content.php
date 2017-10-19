<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_image_content')):
   class gsc_image_content{
      public function render_form(){
         return array(
           'type'          => 'gsc_image_content',
            'title'        => t('Image content'),
            'size'         => 3,
            'icon'         => 'fa fa-bars',
            'fields' => array(
            
               array(
                  'id'        => 'title',
                  'type'      => 'textlangs',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),

               array(
                  'id'        => 'sub_title',
                  'type'      => 'textlangs',
                  'title'     => t('Sub Title'),
               ),

               array(
                  'id'        => 'background',
                  'type'      => 'upload',
                  'title'     => t('Background images')
               ),
         
               array(
                  'id'        => 'content',
                  'type'      => 'textarealangs',
                  'title'     => t('Content'),
                  'desc'      => t('Some HTML tags allowed'),
               ),

               array(
                  'id'        => 'link',
                  'type'      => 'text',
                  'title'     => t('Link'),
                  'desc'      => 'Enter full link or /node/123'
               ),

               array(
                  'id'        => 'text_link',
                  'type'      => 'textlangs',
                  'title'     => t('Text Link'),
               ),

               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link'),
                  'options'   => array( 'off' => 'No', 'on' => 'Yes' ),
                  'std'       => 'on'
               ),

               array(
                  'id'        => 'skin',
                  'type'      => 'select',
                  'title'     => t('Skin'),
                  'options'   => array( 
                     'skin-v1'            => t('Skin v1'), 
                     'skin-v2'            => t('Skin v2'),
                     'skin-v3'            => t('Skin v3: use sub-title'),
                     'skin-v1 skin-v4'    => t('SKin v4'),
                     'skin-v5'            => t('SKin v5: Horizontal')
                  ),
               ),

               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'desc'      => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate(),
               ),
         
            ),                                     
         );
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
            print self::sc_image_content( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_image_content( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'title'              => '',
            'sub_title'          => '',
            'background'         => '',
            'link'               => '',
            'text_link'          => 'Read more',
            'target'             => '',
            'skin'               => 'skin-v1',
            'el_class'           => '',
            'animate'            => ''
         ), $attr));
         
         $link = gavias_render_textlangs($link);
         if($link && $link != '#' && !gavias_elements_check_link($link)){
            $link = $base_url . $link;
         }

         // target
         if( $target == 'on'){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }
         
         if($background) $background = $base_url . '/' .$background; 

         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }

         if($skin) $el_class .= ' ' . $skin;

         ?>
         <?php ob_start() ?>
         
         <?php if($skin == 'skin-v1' || $skin == 'skin-v2' || $skin == 'skin-v5'){ ?>
            <div class="gsc-image-content <?php print $el_class; ?>">
               <div class="image"><?php if($link){ ?><a <?php print $target ?> href="<?php print $link ?>"><?php } ?><img src="<?php print $background ?>" alt="<?php print gavias_render_textlangs($title) ?>" /><?php if($link){ ?></a><?php } ?></div>
               <div class="content">
                  <?php if($title){ ?><h4 class="title">
                     <?php if($link){ ?><a <?php print $target ?> href="<?php print $link ?>"><?php } ?>
                        <?php print gavias_render_textlangs($title) ?>
                     <?php if($link){ ?></a><?php } ?>  
                  </h4><?php } ?>   
                  <div class="desc"><?php print gavias_render_textarealangs($content); ?></div>
               </div>  
               <?php if($link){ ?>
                  <div class="read-more"><a <?php print $target ?> href="<?php print $link ?>"><?php print gavias_render_textlangs($text_link) ?> <i class="fa fa-long-arrow-right"></i></a></div>
               <?php } ?>
            </div>

         <?php }elseif($skin == 'skin-v3'){ ?>

            <div class="gsc-image-content <?php print $el_class; ?>">
               <div class="image"><?php if($link){ ?><a <?php print $target ?> href="<?php print $link ?>"><?php } ?><img src="<?php print $background ?>" alt="<?php print gavias_render_textlangs($title) ?>" /><?php if($link){ ?></a><?php } ?></div>
               <div class="content">
                  <?php if($sub_title){ ?>
                     <span class="sub-title"><?php print gavias_render_textlangs($sub_title) ?></span>
                  <?php } ?>
                  <?php if($title){ ?><h4 class="title">
                     <?php if($link){ ?><a <?php print $target ?> href="<?php print $link ?>"><?php } ?>
                        <?php print gavias_render_textlangs($title) ?>
                     <?php if($link){ ?></a><?php } ?>  
                  </h4><?php } ?>   
                  <div class="desc"><?php print gavias_render_textarealangs($content); ?></div>
               </div>  
            </div>

         <?php }else{ ?>
            <div class="gsc-image-content <?php print $el_class; ?>">
               <div class="image"><?php if($link){ ?><a <?php print $target ?> href="<?php print $link ?>"><?php } ?><img src="<?php print $background ?>" alt="<?php print gavias_render_textlangs($title) ?>" /><?php if($link){ ?></a><?php } ?></div>
               <div class="content">
                  <?php if($sub_title){ ?>
                     <span class="sub-title"><?php print gavias_render_textlangs($sub_title) ?></span>
                  <?php } ?>
                  <?php if($title){ ?><h4 class="title">
                     <?php if($link){ ?><a <?php print $target ?> href="<?php print $link ?>"><?php } ?>
                        <?php print gavias_render_textlangs($title) ?>
                     <?php if($link){ ?></a><?php } ?>  
                  </h4><?php } ?>   
                  <div class="desc"><?php print gavias_render_textarealangs($content); ?></div>
               </div>  
            </div>
         <?php } ?>

         <?php return ob_get_clean() ?>
        <?php            
      } 

      public function load_shortcode(){
         add_shortcode( 'image_content', array($this, 'sc_image_content'));
      }
   }
endif;   
