/*!
 * Menu Pages Extension
 *
 * Copyright: © 2014 <pan.vagenas@gmail.com>
 *
 * @author Panagiotis Vagenas
 * @package XDaRk\Core
 * @since 141226
 */

(function ($) // Begin extension closure.
{
    'use strict'; // Strict standards.

    $('.documentation-btn').click(function (e) {
        e.preventDefault();
    });

    var $xd = $xd_v141226_dev;
    if ($xd.___did_menu_pages)
        return; // Already did these.

    $.each($xd.$.___plugin_root_namespaces,
        function (plugin_root_ns_index, plugin_root_ns) {
            var extension // Extension definition.
                = $xd.$.extension_class(plugin_root_ns, 'menu_pages');
            window['$' + plugin_root_ns].$menu_pages = new extension();
            var _ = window['$' + plugin_root_ns].$menu_pages;

            _.toggling_all_panels = false;

            _.on_dom_ready = function () {
                var $menu_page = _.$menu_page();
                var $content_panels = _.$content_panels();
                var $sidebar_panels = _.$sidebar_panels();
                var $content_sidebar_panels = _.$content_sidebar_panels();

                $('#wpbody').addClass(_.closest_theme_class_to($menu_page))
                    .css({'margin-left': '-20px', 'padding-left': '20px', 'min-height': screen.height + 'px'});

                $menu_page.find('.toggle-all-panels')
                    .on('click', function () {
                        _.toggling_all_panels = true;
                        var $this = $(this), last_action = $this.data('last-action');
                        var this_action = last_action === 'show' ? 'hide' : 'show';

                        $this.data('last-action', this_action), $content_sidebar_panels.find('> .panel-collapse')
                            [_.core('->collapse')]({toggle: false})[_.core('->collapse')](this_action);

                        setTimeout(function () // Wait for transitions to complete.
                        {
                            _.toggling_all_panels = false, // Now update panels state.
                                update_content_panels_state(), update_sidebar_panels_state();
                        }, 2000);
                    });

                $menu_page.find('.update-theme ul > li')
                    .on('click', function () {
                        $menu_page.find('.update-theme')
                            .find('input.selected-theme').val($(this).data('theme'))
                            .closest('form').submit();
                    });

                var update_content_panels_state = function () {
                    if (_.toggling_all_panels)
                        return; // Ignore this scenario.

                    var panels_active = [], panels_inactive = [];

                    $content_panels.each(function () {
                        var $this = $(this);
                        if ($this.find('> .panel-collapse').hasClass('in'))
                            panels_active.push($this.data('panel-slug'));
                        else panels_inactive.push($this.data('panel-slug'));
                    });
                    _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_content_panels_state',
                        _.___private_type, [panels_active, panels_inactive]);
                    console.log('Updating content panels state.');
                };
                $content_panels.find('> .panel-collapse')
                    .on('shown.' + _.core('-bs') + '.collapse', update_content_panels_state)
                    .on('hidden.' + _.core('-bs') + '.collapse', update_content_panels_state);

                var update_sidebar_panels_state = function () {
                    if (_.toggling_all_panels)
                        return; // Ignore this scenario.

                    var panels_active = [], panels_inactive = [];

                    $sidebar_panels.each(function () {
                        var $this = $(this);
                        if ($this.find('> .panel-collapse').hasClass('in'))
                            panels_active.push($this.data('panel-slug'));
                        else panels_inactive.push($this.data('panel-slug'));
                    });
                    _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_sidebar_panels_state',
                        _.___private_type, [panels_active, panels_inactive]);
                    console.log('Updating sidebar panels state.');
                };
                $sidebar_panels.find('> .panel-collapse')
                    .on('shown.' + _.core('-bs') + '.collapse', update_sidebar_panels_state)
                    .on('hidden.' + _.core('-bs') + '.collapse', update_sidebar_panels_state);

                var update_content_panels_order = function () {
                    var panels_order = [];

                    $menu_page.find('.content-panels > .panel')
                        .each(function () {
                            var $this = $(this);
                            panels_order.push($this.data('panel-slug'));
                        });
                    _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_content_panels_order',
                        _.___private_type, [panels_order]);
                    console.log('Updating content panels order.');
                };
                $menu_page.find('.content-panels')
                    [_.core('->sortable')]({
                    items: '.panel',
                    // $(.sidebar-panels).children(.panel)
                    // $(.sidebar-panels).children(.panel).find(handle)
                    handle: '> .panel-heading > .panel-title .cursor-move'
                });
                $menu_page.find('.content-panels').on('sortupdate', update_content_panels_order);

                var update_sidebar_panels_order = function () {
                    var panels_order = [];

                    $menu_page.find('.sidebar-panels > .panel')
                        .each(function () {
                            var $this = $(this);
                            panels_order.push($this.data('panel-slug'));
                        });
                    _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_sidebar_panels_order',
                        _.___private_type, [panels_order]);
                    console.log('Updating sidebar panels order.');
                };
                $menu_page.find('.sidebar-panels')
                    [_.core('->sortable')]({
                    items: '.panel',
                    // $(.sidebar-panels).children(.panel)
                    // $(.sidebar-panels).children(.panel).find(handle)
                    handle: '> .panel-heading > .panel-title .cursor-move'
                });
                $menu_page.find('.sidebar-panels').on('sortupdate', update_sidebar_panels_order);

                $menu_page
                    .find('.activate-lic')
                    .on('click', function () {
                        //$menu_page.find('.activate-license-form')
                        //   .find('input.license')
                        //   .val($('#license').val())
                        //   .closest('form').submit();
                        //

                        var license = $('#license').val();
                        var $res = _.post(
                            '©edd_updater.®ajaxActivateLicense',
                            _.___private_type,
                            [license],
                            {
                                complete: function (response) {
                                    location.reload();
                                }
                            }
                        );
                    });

                $menu_page
                    .find('.deactivate-lic')
                    .click(function () {
                        var license = $('#license').val();
                        var $res = _.post(
                            '©edd_updater.®ajaxDeactivateLicense',
                            _.___private_type,
                            [license],
                            {
                                complete: function (response) {
                                    location.reload();
                                }
                            }
                        );
                    }
                );

                $menu_page
                    .find('.input-media-wrapper').each(function(){
                        var $wrapper = $(this);
                        var $input = $wrapper.find('.media-input');
                        $wrapper
                            .find('.input-media-btn')
                            .click(function () {
                                _.openFileFrame($input);
                            }
                        )
                    });
            };

            _.on_win_load = function () {
                var $menu_page = _.$menu_page();

                var content_panel_slug = _.get_query_var('content_panel_slug');
                var sidebar_panel_slug = _.get_query_var('sidebar_panel_slug');
                var $content_panel, $sidebar_panel; // Initialize.

                if (content_panel_slug // Focusing on a specific content panel?
                    && ($content_panel = $menu_page.find('.content-panels #panel--' + content_panel_slug + '.panel-collapse')).length) {
                    var scroll_to_content_panel = function () {
                        $[_.core('->scrollTo')]($content_panel.prev('.panel-heading'), {
                            offset: {top: -100, left: 0},
                            duration: 500
                        });
                    };
                    if ($content_panel.hasClass('in')) scroll_to_content_panel(); // Expanded already.
                    else $content_panel.one('shown.' + _.core('-bs') + '.collapse', scroll_to_content_panel),
                        $content_panel[_.core('->collapse')]({toggle: false})[_.core('->collapse')]('show');
                }
                if (sidebar_panel_slug // Focusing on a specific sidebar panel?
                    && ($sidebar_panel = $menu_page.find('.sidebar-panels #panel--' + sidebar_panel_slug + '.panel-collapse')).length) {
                    var scroll_to_sidebar_panel = function () {
                        if (!content_panel_slug) // Only if we are NOT also scrolling to a content panel.
                            $[_.core('->scrollTo')]($sidebar_panel.prev('.panel-heading'), {
                                offset: {
                                    top: -100,
                                    left: 0
                                }, duration: 500
                            });
                    };
                    if ($sidebar_panel.hasClass('in')) scroll_to_sidebar_panel(); // Expanded already.
                    else $sidebar_panel.one('shown.' + _.core('-bs') + '.collapse', scroll_to_sidebar_panel),
                        $sidebar_panel[_.core('->collapse')]({toggle: false})[_.core('->collapse')]('show');
                }
            };

            _.$menu_page = function () {
                if (_.cache.$menu_page)
                    return _.cache.$menu_page;

                return (_.cache.$menu_page // Current menu page.
                    = $('.' + _.instance('plugin_root_ns_with_dashes') + '.menu-page'));
            };

            _.$content_panels = function () {
                if (_.cache.$content_panels)
                    return _.cache.$content_panels;

                return (_.cache.$content_panels = _.$menu_page()
                    .find('.content-panels > .panel'));
            };

            _.$sidebar_panels = function () {
                if (_.cache.$sidebar_panels)
                    return _.cache.$sidebar_panels;

                return (_.cache.$sidebar_panels = _.$menu_page()
                    .find('.sidebar-panels > .panel'));
            };

            _.$content_sidebar_panels = function () {
                if (_.cache.$content_sidebar_panels)
                    return _.cache.$content_sidebar_panels;

                return (_.cache.$content_sidebar_panels = _.$menu_page()
                    .find('.content-panels > .panel, .sidebar-panels > .panel'));
            };

            _.openFileFrame = function ($input) {
                if (undefined === $input.file_frame) {
                    $input.file_frame = wp.media.frames.file_frame = wp.media({
                        title: "Insert Media", // For production, this needs i18n.
                        button: {
                            text: "Upload Image" // For production, this needs i18n.
                        },
                        multiple: false
                    });
                } else {
                    $input.file_frame.open();
                    return;
                }

                $input.file_frame.on('select', function () {
                    var image_data = $input.file_frame.state().get('selection').first().toJSON();
                    $input.val(image_data['url']);
                });

                $input.file_frame.open();
                return true;
            };

            $(document).on('ready', _.on_dom_ready), $(window).on('load', _.on_win_load);
        });
    $xd.___did_menu_pages = true;

})(jQuery); // End extension closure.