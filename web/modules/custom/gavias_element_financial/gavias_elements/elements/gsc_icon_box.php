<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_icon_box')):
   class gsc_icon_box{

      public function render_form(){
         $fields = array(
            'type' => 'gsc_icon_box',
            'title' => ('Icon Box'), 
            'size' => 3,'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'textlangs',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarealangs',
                  'title'     => t('Content'),
                  'desc'      => t('Some Shortcodes and HTML tags allowed'),
               ),
               array(
                  'id'        => 'icon',
                  'type'      => 'text',
                  'title'     => t('Icon class'),
                  'std'       => '',
                  'desc'     => t('Use class icon font <a target="_blank" href="http://fontawesome.io/icons/">Icon Awesome</a>'),
               ),
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t('Image Icon'),
                  'desc'      => t('Use image icon instead of icon class'),
               ),
               array(
                  'id'            => 'icon_position',
                  'type'          => 'select',
                  'options'       => array(
                     'top-center'         => 'Top Center',
                     'top-center round'   => 'Top Center v2',
                     'top-center v3'      => 'Top Center v3',
                     'top-left'           => 'Top Left',
                     'top-left v2'        => 'Top Left v2',
                     'top-left v3'        => 'Top Left v3',
                     'top-right'          => 'Top Right',
                     'right'              => 'Right',
                     'left'               => 'Left',
                     'left box-small'     => 'Left Icon small',
                     'top-left-title'     => 'Top Left Title',
                     'top-right-title'    => 'Top Right Title'
                  ),
                  'title'  => t('Icon Position'),
                  'std'    => 'top',
               ),
               array(
                  'id'        => 'min_height',
                  'type'      => 'text',
                  'title'     => t('Min Height'),
                  'desc'      => t('Set Min Height for icon box, e.g: 340px')
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'textlangs',
                  'title'     => t('Link'),
                  'desc'      => t('Link for text')
               ),
               array(
                  'id'        => 'bg_color',
                  'type'      => 'text',
                  'title'     => t('Icon Background color'),
                  'desc'      => t('Background for icon, e.g: #f5f5f5')
               ),
               array(
                  'id'        => 'bg_box',
                  'type'      => 'text',
                  'title'     => t('Background Box'),
                  'desc'      => t('Background for Box, e.g: #f5f5f5')
               ),
               array(
                  'id'        => 'skin_text',
                  'type'      => 'select',
                  'title'     => 'Skin Text for box',
                  'options'   => array(
                     'text-dark'  => t('Text Dark'), 
                     'text-light' => t('Text Light')
                  ) 
               ),
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'options'   => array( 'on' => 'No', 'off' => 'Yes' ),
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link.'),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'desc'      => t('Entrance animation for element'),
                  'options'   => gavias_blockbuilder_animate(),
               ), 
               array(
                  'id'     => 'el_class',
                  'type'      => 'text',
                  'title'  => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),

            ),                                       
         );
         return $fields;
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
         print self::sc_icon_box( $item['fields'], $item['fields']['content'] );
      }


      public static function sc_icon_box( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'title'           => '',
            'icon'            => '',
            'image'           => '',
            'icon_color'      => '',
            'icon_position'   => 'top',
            'link'            => '',
            'skin_text'       => '',
            'target'          => '',
            'animate'         => '',
            'min_height'      => '',
            'el_class'        => '',
            'bg_color'        => '',
            'bg_box'          => ''
         ), $attr));
         if($image) $image = $base_url . $image; 

         // target
         if( $target ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }

         $class = array();
         if($el_class){ $class[] = $el_class; }
         $class[] = $icon_position;
         if($skin_text){$class[] = $skin_text;}

         $bg_icon = "";
         $color_icon = "";
         if($bg_color){
            $bg_icon = "style=\"background-color: {$bg_color}\"";
            $color_icon = "style=\"color: {$bg_color}\"";
         }

         $style = array();
         if(isset($min_height) && $min_height){
            $style[] = "min-height:{$min_height};";
         }
         if(isset($bg_box) && $bg_box){
            $style[] = "background-color: {$bg_box};";
         }
         if($animate){
            $class[] = 'wow';
            $class[] = $animate;
         }
         $link = gavias_render_textlangs($link);
         ?>
         <?php ob_start() ?>
         <?php if($icon_position == 'top-left v3'){ ?>

            <div class="widget gsc-icon-box <?php if(count($class)>0) print implode($class, ' ') ?>" <?php if(count($style) > 0) print 'style="'.implode($style, ';').'"' ?>>
               <?php if($icon){ ?>
                  <div class="highlight-icon"<?php print $color_icon ?>><span class="icon <?php print $icon ?>"></span></div>
               <?php }?>
               <?php if($image){ ?>
                  <div class="highlight-icon"><span class="icon"><img src="<?php print $image ?>"/></span></div>
               <?php }?>
               <div class="highlight_content">
                     <h4 <?php print $color_icon ?>>
                     <?php if($link){ ?> 
                     <a href="<?php echo $link ?>" title="" <?php print $color_icon ?>> <?php } ?>
                        <?php print gavias_render_textlangs($title); ?> <?php if($link){ ?> 
                     </a> 
                     <?php } ?>
                     </h4>
                  <?php if($content){ ?>
                     <div class="desc"><?php print do_shortcode(gavias_render_textarealangs($content)); ?></div>
                  <?php } ?>   
               </div>
            </div> 

         <?php }else{ ?>
         
            <div class="widget gsc-icon-box <?php if(count($class)>0) print implode($class, ' ') ?>" <?php if(count($style) > 0) print 'style="'.implode($style, ';').'"' ?>>
               <?php if($icon){ ?>
                  <div class="highlight-icon" <?php print $bg_icon ?>><span class="icon <?php print $icon ?>"></span></div>
               <?php }?>
               <?php if($image){ ?>
                  <div class="highlight-icon"><span class="icon"><img src="<?php print $image ?>"/></span></div>
               <?php }?>
               <div class="highlight_content">
                     <h4><?php if($link){ ?> <a href="<?php echo $link ?>"> <?php } ?><?php print gavias_render_textlangs($title); ?> <?php if($link){ ?> </a> <?php } ?></h4>
                  <?php if($content){ ?>
                     <div class="desc"><?php print do_shortcode(gavias_render_textarealangs($content)); ?></div>
                  <?php } ?>   
               </div>
            </div> 

         <?php } ?>   

         <?php return ob_get_clean() ?>
       <?php
      }

      public function load_shortcode(){
         add_shortcode( 'icon_box', array($this, 'sc_icon_box') );
      }
   } 
endif;   
