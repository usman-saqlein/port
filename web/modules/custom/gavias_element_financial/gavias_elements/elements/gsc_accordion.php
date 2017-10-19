<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_accordion')):
   class gsc_accordion{
      public function render_form(){
         $fields = array(
            'type'      => 'gsc_accordion',
            'title'  => t('Accordion'), 
            'size'      => 3, 
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'style',
                  'type'      => 'select',
                  'title'     => t('Style'),
                  'options'   => array( 
                     'skin-white'         => 'Background White',
                     'skin-dark'          => 'Background Dark',
                     'skin-white-border'  => 'Background White Border',
                  ),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'desc'      => t('Entrance animation for element'),
                  'options'   => gavias_blockbuilder_animate(),
               ),
               
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
            ),                                           
         );
         for($i=1; $i<=10; $i++){
            $fields['fields'][] = array(
               'id'     => "info_${i}",
               'type'   => 'info',
               'desc'   => "Information for item {$i}"
            );
            $fields['fields'][] = array(
               'id'        => "title_{$i}",
               'type'      => 'textlangs',
               'title'     => t("Title {$i}")
            );
            $fields['fields'][] = array(
               'id'           => "content_{$i}",
               'type'         => 'textarealangs',
               'title'        => t("Content {$i}")
            );
         }
      return $fields;
      }

      public function render_content( $item ) {
         print self::render_element_accordion( $item['fields'] );
      }

      public static function render_element_accordion($attr, $content = null){
         $default = array(
            'title'      => '',
            'style'     => 'skin-white',
            'el_class'   => '',
            'animate'    => '',
         );
         for($i=1; $i<=10; $i++){
            $default["title_{$i}"] = '';
            $default["content_{$i}"] = '';
         }
         extract(shortcode_atts($default, $attr));

         $_id = 'accordion-' . gavias_blockbuilder_makeid();
         $classes = $el_class;
         $classes .= ' ' . $style;
         
         if($animate){
            $classes .= ' wow';
            $classes .= ' '. $animate;
         }

         ?>
          <?php ob_start() ?>
         <div class="gsc-accordion">
            <div class="panel-group <?php print $classes ?>" id="<?php print $_id; ?>" role="tablist" aria-multiselectable="true">
            <?php for($i=1; $i<=10; $i++){ ?>
               <?php 
                  $title = "title_{$i}";
                  $content = "content_{$i}";
               ?>
               <?php if(gavias_render_textlangs($$title)){ ?>
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" class="<?php print ($i == 1) ? '' : 'collapsed' ?>" data-parent="#<?php print $_id; ?>" href="#<?php print ($_id . '-' . $i) ?>" aria-expanded="true">
                            <?php print gavias_render_textlangs($$title) ?>
                          </a>
                        </h4>
                     </div>
                     <div id="<?php print ($_id . '-' . $i) ?>" class="panel-collapse collapse<?php if($i==1) print ' in' ?>" role="tabpanel">
                        <div class="panel-body">
                           <?php print do_shortcode(gavias_render_textarealangs($$content)) ?>
                        </div>
                     </div>
                  </div>
               <?php } ?>   
            <?php } ?>
            </div>
         </div>
         <?php return ob_get_clean() ?>
      <?php  
      }

      public static function sc_accordion( $attr, $content = null ){
         global $accordion_array, $tabs_count;
         extract(shortcode_atts(array(
            'title'     => '',
            'style'     => 'skin-dark',
            'animate'   => '',
            'el_class'  => ''
         ), $attr));
         do_shortcode( $content );

         $_id = 'accordion-' . gavias_blockbuilder_makeid();
         $classes = $el_class;
         $classes .= ' ' . $style;
         if($animate){
            $classes .= ' wow';
            $classes .= ' '. $animate;
         }

         ?>
          <?php ob_start() ?>
         <div class="gsc-accordion">
            <div class="panel-group <?php print $classes ?>" id="<?php print $_id; ?>" role="tablist" aria-multiselectable="true">
              <?php
               if( is_array( $accordion_array ) ){ 
                  $i=0;
                  foreach( $accordion_array as $tab ){ $i = $i + 1;
               ?>
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" class="<?php print ($i == 1) ? '' : 'collapsed' ?>" data-parent="#<?php print $_id; ?>" href="#<?php print ($_id . '-' . $i) ?>" aria-expanded="true">
                            <?php print $tab['title'] ?>
                          </a>
                        </h4>
                     </div>
                     <div id="<?php print ($_id . '-' . $i) ?>" class="panel-collapse collapse<?php if($i==1) print ' in' ?>" role="tabpanel">
                        <div class="panel-body">
                           <?php print do_shortcode($tab['content']) ?>
                        </div>
                     </div>
                  </div>
               <?php }
               } 
               $accordion_array = '';
             ?>   
            </div>
         </div>
         <?php return ob_get_clean() ?>
      <?php    
      }
      
      public static function sc_accordion_item( $attr, $content = null ){
         global $accordion_array, $tabs_count;
         extract(shortcode_atts(array(
            'title'  => '',
         ), $attr));

         $accordion_array[] = array(
            'title' => $title,
            'content' => do_shortcode( $content )
         );

         $tabs_count++;
         return true;
      }

      public function load_shortcode(){
         add_shortcode( 'accordion', array($this, 'sc_accordion'));
         add_shortcode( 'accordion_item', array($this, 'sc_accordion_item') );
      }
      
   }

endif;