<!-- BEGIN #top-menu -->
<div id="top-menu" class="app-top-menu" data-bs-theme="dark">
    <!-- BEGIN menu -->
    <div class="menu">
        @php
            $currentUrl = Request::path() != '/' ? '/' . Request::path() : '/';

            if (!function_exists('renderHeaderSubMenu')) {
                function renderHeaderSubMenu($value, $currentUrl)
                {
                    $subMenu = '';
                    $GLOBALS['sub_level'] += 1;
                    $GLOBALS['active'][$GLOBALS['sub_level']] = '';
                    $currentLevel = $GLOBALS['sub_level'];
                    foreach ($value as $key => $menu) {
                        $GLOBALS['subparent_level'] = '';

                        $subSubMenu = '';
                        $hasPermission = !empty($menu['permission']) ? $menu['permission'] : '';
                        $hasSub = !empty($menu['sub_menu']) ? 'has-sub' : '';
                        $hasBG = !empty($menu['BG']) ? $menu['BG'] : '';
                        $hasCaret = !empty($menu['sub_menu']) ? '<div class="menu-caret"></div>' : '';
                        $hasHighlight = !empty($menu['highlight'])
                            ? '<i class="fa fa-paper-plane text-theme ms-1"></i>'
                            : '';
                        $hasTitle = !empty($menu['title'])
                            ? '<div class="menu-text">' . $menu['title'] . $hasHighlight . '</div>'
                            : '';

                        if (!empty($menu['sub_menu'])) {
                            $subSubMenu .= '<div class="menu-submenu">';
                            $subSubMenu .= renderHeaderSubMenu($menu['sub_menu'], $currentUrl);
                            $subSubMenu .= '</div>';
                        }

                        $active =
                            !empty($menu['route-name']) && Route::currentRouteName() == $menu['route-name']
                                ? 'active'
                                : '';

                        if ($active) {
                            $GLOBALS['parent_active'] = true;
                            $GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
                        }
                        if (!empty($GLOBALS['active'][$currentLevel])) {
                            $active = 'active';
                        }

                        // Generar la URL utilizando el helper `route` o utilizar la URL directa
                        $menuUrl = !empty($menu['route-name']) ? route($menu['route-name']) : '#';

                        if (!empty($hasPermission)) {
                            if (
                                auth()
                                    ->user()
                                    ->canAny($menu['permission'])
                            ) {
                                $subMenu .=
                                    '<div class="menu-item ' .
                                    $hasSub .
                                    ' ' .
                                    $active .
                                    '">
                                    <a href="' .
                                    $menuUrl .
                                    '" class="menu-link ' .
                                    $hasBG .
                                    '">' .
                                    $hasTitle .
                                    $hasCaret .
                                    '</a>
                                    ' .
                                    $subSubMenu .
                                    '
                                </div>';
                            }
                        }
                    }
                    return $subMenu;
                }
            }

            foreach (config('sidebar.menu') as $key => $menu) {
                $GLOBALS['parent_active'] = '';

                $hasRole = !empty($menu['role'])
                    ? auth()
                        ->user()
                        ->hasRole($menu['role'])
                    : '';
                $hasPermission = !empty($menu['permission']) ? $menu['permission'] : '';
                $hasSub = !empty($menu['sub_menu']) ? 'has-sub' : '';
                $hasBG = !empty($menu['BG']) ? $menu['BG'] : '';
                $hasCaret = !empty($menu['caret']) ? '<div class="menu-caret"></div>' : '';
                $hasIcon = !empty($menu['icon'])
                    ? '<div class="menu-icon"><i class="' . $menu['icon'] . '"></i></div>'
                    : '';
                $hasImg = !empty($menu['img'])
                    ? '<div class="menu-icon-img"><img src="' . $menu['img'] . '" /></div>'
                    : '';
                $hasLabel = !empty($menu['label']) ? '<span class="menu-label">' . $menu['label'] . '</span>' : '';
                $hasTitle = !empty($menu['title'])
                    ? '<div class="menu-text">' . $menu['title'] . $hasLabel . '</div>'
                    : '';
                $hasBadge = !empty($menu['badge']) ? '<div class="menu-badge">' . $menu['badge'] . '</div>' : '';

                $subMenu = '';

                if (!empty($menu['sub_menu'])) {
                    $GLOBALS['sub_level'] = 0;
                    $subMenu .= '<div class="menu-submenu">';
                    $subMenu .= renderHeaderSubMenu($menu['sub_menu'], $currentUrl);
                    $subMenu .= '</div>';
                }

                $active =
                    !empty($menu['route-name']) && Route::currentRouteName() == $menu['route-name'] ? 'active' : '';
                $active = empty($active) && !empty($GLOBALS['parent_active']) ? 'active' : $active;

                // Generar la URL utilizando el helper `route` o utilizar la URL directa
                $menuUrl = !empty($menu['route-name']) ? route($menu['route-name']) :  '#';

                if (auth()->user()->canAny($hasPermission)) {
                    if (
                        auth()
                            ->user()
                            ->hasRole($menu['role'])
                    ) {
                        echo '
                        <div class="menu-item ' .
                            $hasSub .
                            ' ' .
                            $active .
                            '">
                            <a href="' .
                            $menuUrl .
                            '" class="menu-link ' .
                            $hasBG .
                            '">' .
                            $hasImg .
                            '
                                ' .
                            $hasIcon .
                            '
                                ' .
                            $hasTitle .
                            '
                                ' .
                            $hasBadge .
                            '
                                ' .
                            $hasCaret .
                            '
                            </a>
                            ' .
                            $subMenu .
                            '
                        </div>';
                    }
                }
            }
        @endphp
        <div class="menu-item menu-control menu-control-start">
            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-prev"><i class="fa fa-angle-left"></i></a>
        </div>
        <div class="menu-item menu-control menu-control-end">
            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-next"><i
                    class="fa fa-angle-right"></i></a>
        </div>
    </div>
    <!-- END menu -->
</div>
<!-- END #top-menu -->


{{-- <!-- BEGIN #top-menu -->
<div id="top-menu" class="app-top-menu" data-bs-theme="dark">
    <!-- BEGIN menu -->
    <div class="menu">
        @php
            $currentUrl = Request::path() != '/' ? '/' . Request::path() : '/';

            function renderHeaderSubMenu($value, $currentUrl)
            {
                $subMenu = '';
                $GLOBALS['sub_level'] += 1;
                $GLOBALS['active'][$GLOBALS['sub_level']] = '';
                $currentLevel = $GLOBALS['sub_level'];
                foreach ($value as $key => $menu) {
                    $GLOBALS['subparent_level'] = '';

                    $subSubMenu = '';
                    $hasPermission = !empty($menu['permission']) ? $menu['permission'] : '';
                    $hasSub = !empty($menu['sub_menu']) ? 'has-sub' : '';
                    $hasBG = !empty($menu['BG']) ? $menu['BG'] : '';
                    $hasCaret = !empty($menu['sub_menu']) ? '<div class="menu-caret"></div>' : '';
                    $hasHighlight = !empty($menu['highlight'])
                        ? '<i class="fa fa-paper-plane text-theme ms-1"></i>'
                        : '';
                    $hasTitle = !empty($menu['title'])
                        ? '<div class="menu-text">' . $menu['title'] . $hasHighlight . '</div>'
                        : '';

                    if (!empty($menu['sub_menu'])) {
                        $subSubMenu .= '<div class="menu-submenu">';
                        $subSubMenu .= renderHeaderSubMenu($menu['sub_menu'], $currentUrl);
                        $subSubMenu .= '</div>';
                    }

                    $active =
                        !empty($menu['route-name']) && Route::currentRouteName() == $menu['route-name'] ? 'active' : '';

                    if ($active) {
                        $GLOBALS['parent_active'] = true;
                        $GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
                    }
                    if (!empty($GLOBALS['active'][$currentLevel])) {
                        $active = 'active';
                    }
                    if (!empty($hasPermission)) {
                        if (
                            auth()
                                ->user()
                                ->canAny($menu['permission'])
                        ) {
                            $subMenu .=
                                '<div class="menu-item ' .
                                $hasSub .
                                ' ' .
                                $active .
                                '">
								<a href="' .
                                $menu['url'] .
                                '" class="menu-link ' .
                                $hasBG .
                                '"' .
                                $menu['WN'] .
                                '>' .
                                $hasTitle .
                                $hasCaret .
                                '</a>
								' .
                                $subSubMenu .
                                '
							</div>
						';
                        }
                    }
                }
                return $subMenu;
            }

            foreach (config('sidebar.menu') as $key => $menu) {
                $GLOBALS['parent_active'] = '';

                $hasRole = !empty($menu['role'])
                    ? auth()
                        ->user()
                        ->hasRole($menu['role'])
                    : '';
                $hasPermission = !empty($menu['permission']) ? $menu['permission'] : '';
                $hasSub = !empty($menu['sub_menu']) ? 'has-sub' : '';
                $hasBG = !empty($menu['BG']) ? $menu['BG'] : '';
                $hasCaret = !empty($menu['caret']) ? '<div class="menu-caret"></div>' : '';
                $hasIcon = !empty($menu['icon'])
                    ? '<div class="menu-icon"><i class="' . $menu['icon'] . '"></i></div>'
                    : '';
                $hasImg = !empty($menu['img'])
                    ? '<div class="menu-icon-img"><img src="' . $menu['img'] . '" /></div>'
                    : '';
                $hasLabel = !empty($menu['label']) ? '<span class="menu-label">' . $menu['label'] . '</span>' : '';
                $hasTitle = !empty($menu['title'])
                    ? '<div class="menu-text">' . $menu['title'] . $hasLabel . '</div>'
                    : '';
                $hasBadge = !empty($menu['badge']) ? '<div class="menu-badge">' . $menu['badge'] . '</div>' : '';

                $subMenu = '';

                if (!empty($menu['sub_menu'])) {
                    $GLOBALS['sub_level'] = 0;
                    $subMenu .= '<div class="menu-submenu">';
                    $subMenu .= renderHeaderSubMenu($menu['sub_menu'], $currentUrl);
                    $subMenu .= '</div>';
                }
                $active =
                    !empty($menu['route-name']) && Route::currentRouteName() == $menu['route-name'] ? 'active' : '';
                $active = empty($active) && !empty($GLOBALS['parent_active']) ? 'active' : $active;
                if (auth()->user()->canAny($hasPermission)) {
                    if (
                        auth()
                            ->user()
                            ->hasRole($menu['role'])
                    ) {
                        echo '
						<div class="menu-item ' .
                            $hasSub .
                            ' ' .
                            $active .
                            '">
							<a href="' .
                            $menu['url'] .
                            '" class="menu-link ' .
                            $hasBG .
                            '"' .
                            $menu['WN'] .
                            '>' .
                            $hasImg .
                            '
								' .
                            $hasIcon .
                            '
								' .
                            $hasTitle .
                            '
								' .
                            $hasBadge .
                            '
								' .
                            $hasCaret .
                            '
							</a>
							' .
                            $subMenu .
                            '
						</div>
					';
                    }
                }
            }
        @endphp
        <div class="menu-item menu-control menu-control-start">
            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-prev"><i class="fa fa-angle-left"></i></a>
        </div>
        <div class="menu-item menu-control menu-control-end">
            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-next"><i
                    class="fa fa-angle-right"></i></a>
        </div>
    </div>
    <!-- END menu -->
</div>
<!-- END #top-menu -->
 --}}
