<?php
/*
  WPFront Plugins Base Menu
  Copyright (C) 2013, WPFront.com
  Website: wpfront.com
  Contact: syam@wpfront.com

  WPFront Plugins are distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

if (!class_exists('WPFront_Base_Menu')) {

    class WPFront_Base_Menu {

        const MENU_SLUG = 'wpfront-plugins';

        private static $wpfrontBase = NULL;
        private static $wpfrontBaseMenu = NULL;

        function __construct($wpfrontBase) {
            if (self::$wpfrontBase == NULL) {
                self::$wpfrontBase = $wpfrontBase;
                self::$wpfrontBaseMenu = $this;
            } else {
                if (version_compare($this->version(), self::$wpfrontBaseMenu->version()) > 0) {
                    self::$wpfrontBase = $wpfrontBase;
                    self::$wpfrontBaseMenu = $this;
                }
            }
        }

        protected function version() {
            return '1.0';
        }

        protected function create_admin_menu($menu_data) {
            $menu_slug = $menu_data[0]['slug'];

            global $admin_page_hooks, $submenu;
            if (!isset($admin_page_hooks[$menu_slug])) {
                add_menu_page(__('WPFront', 'wpfront-scroll-top'), __('WPFront', 'wpfront-scroll-top'), 'manage_options', $menu_slug, null, self::$wpfrontBase->pluginURL() . 'classes/base/images/wpfront_menu.png');
            }

            foreach ($menu_data as $value) {
                $flag = FALSE;

                if(!empty($submenu[$menu_slug])) {
                    foreach ($submenu[$menu_slug] as $s) {
                        if ($s[2] == $value['slug']) {
                            $flag = TRUE;
                            break;
                        }
                    }
                }

                if ($flag == TRUE)
                    continue;
                
                $page_hook_suffix = add_submenu_page($menu_slug, $value['title'], $value['link'], 'manage_options', $value['slug'], array($value['this'], 'options_page'));

                add_action('admin_print_scripts-' . $page_hook_suffix, array($value['this'], 'enqueue_options_scripts'));
                add_action('admin_print_styles-' . $page_hook_suffix, array($value['this'], 'enqueue_options_styles'));
            }
        }

        public static function admin_menu($menu_data) {
            self::$wpfrontBaseMenu->create_admin_menu($menu_data);
        }

    }

}
    