<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_our_partners')):
   class gsc_our_partners{

      public function render_form(){
         $fields = array(
            'type'   => 'gsc_our_partners',
            'title'  => t('Our Partners'), 
            'size'   => 3,
            'icon'   => 'fa fa-bars',
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'textlangs',
                  'title'     => t('Name'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t('Photo'),
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarealangs',
                  'title'     => t('Content'),
               ),
               array(
                  'id'        => 'address',
                  'type'      => 'textlangs',
                  'title'     => t('Address'),
               ),
               array(
                  'id'        => 'category',
                  'type'      => 'textlangs',
                  'title'     => t('Category'),
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'textlangs',
                  'title'     => t('Link'),
               ),
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'title'     => ('Open in new window'),
                  'desc'      => ('Adds a target="_blank" attribute to the link.'),
                  'options'   => array( 0 => 'No', 1 => 'Yes' ),
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
                  'sub_desc'  => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate()
               ),
            ),                                      
         );
         return $fields;
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
         print self::sc_our_partners( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_our_partners( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(  
            'title'         => '',
            'image'         => '', 
            'content'       => '',
            'address'       => '',
            'category'      => '',
            'link'          => '',
            'target'        => '',
            'animate'       => '',
            'el_class'     => ''
         ), $attr));
         
         $link = gavias_render_textlangs($link);

         if($image){
            $image = $base_url . $image;
         }
         if( $target ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }

         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }

         ?>
         <?php ob_start() ?>
        
            <div class="widget gsc-our-partners <?php print $el_class ?>">
               <?php if($image){ ?>
                  <div class="image"><img src="<?php print $image ?>" alt="<?php ?>"/></div>
               <?php } ?>

               <div class="content-inner">
                  <?php if(gavias_render_textlangs($title)){ ?>
                     <div class="title">
                        <?php if($link){ ?><a href="<?php $link ?>" <?php print $target ?>><?php } ?> 
                           <?php print gavias_render_textlangs($title) ?>
                        <?php if($link){print '</a>'; } ?>
                     </div>
                  <?php } ?>    
                  <div class="info">
                     <?php if(gavias_render_textlangs($category)){ ?>
                        <span class="category"><?php print gavias_render_textlangs($category) ?>,</span>
                     <?php } ?>
                     <?php if(gavias_render_textlangs($address)){ ?>
                        <span class="address"><?php print gavias_render_textlangs($address) ?></span>
                     <?php } ?>
                  </div>
                  <?php if(gavias_render_textarealangs($content)){ ?>
                     <div class="content"><?php print gavias_render_textarealangs($content) ?></div>
                  <?php } ?>                       
               </div>

            </div>

         <?php return ob_get_clean() ?>
         <?php
      }

      public function load_shortcode(){
         add_shortcode( 'our_team', array('gsc_our_partners', 'sc_our_partners' ));
      }
   }
endif;


