import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
// import { ServerSideRender } from '@wordpress/server-side-render';
import ServerSideRender from '@wordpress/server-side-render';
import {
    PanelBody,
    __experimentalToggleGroupControl as ToggleGroupControl,
    __experimentalToggleGroupControlOption as ToggleGroupControlOption,
    SelectControl,
    TextControl
} from '@wordpress/components';
import { useEffect } from '@wordpress/element';

import './style.scss';
import './editor.scss';

const justifyOptions = [
    { value: 'flex-start', label: __('Left', 'divonex') },
    { value: 'center', label: __('Center', 'divonex') },
    { value: 'flex-end', label: __('Right', 'divonex') }
];

const stacks = [
    { value: 'no-stack', label: __('Off', 'divonex') },
    { value: 'tablet', label: __('Tablet', 'divonex') },
    { value: 'mobile', label: __('Mobile', 'divonex') },
    { value: 'always', label: __('Always', 'divonex') }
];

export default function Edit({ attributes, setAttributes }) {
    const { selectedMenu, alignment, offCanvasPosition, offCanvasMenu, colors, offCanvasMenuColors, offCanvasColors, dropdownBorder, dropdownBorderRadius } = attributes;

    const customCSS = {
        ...(alignment && alignment !== 'flex-start' ? { '--nav-align': alignment } : {}),
        ...(colors.text ? { '--divonex-nav-text-color': colors.text } : {}),
        ...(colors.bg ? { '--divonex-nav-bg-color': colors.bg } : {}),
        ...(colors.bgHover ? { '--divonex-nav-bg-hover-color': colors.bgHover } : {}),
        ...(colors.textHover ? { '--divonex-nav-text-hover-color': colors.textHover } : {}),
        ...(offCanvasMenuColors.text ? { '--divonex-mobile-text-color': offCanvasMenuColors.text } : {}),
        ...(offCanvasMenuColors.bg ? { '--divonex-mobile-bg-color': offCanvasMenuColors.bg } : {}),
        ...(offCanvasMenuColors.textHover ? { '--divonex-mobile-text-hover-color': offCanvasMenuColors.textHover } : {}),
        ...(offCanvasMenuColors.bgHover ? { '--divonex-mobile-bg-hover-color': offCanvasMenuColors.bgHover } : {}),
        ...(offCanvasColors.overlayBg ? { '--divonex-overlay-color': offCanvasColors.overlayBg } : {}),
        ...(offCanvasColors.barsColor ? { '--divonex-bars-color': offCanvasColors.barsColor } : {}),
        ...(offCanvasColors.close ? { '--divonex-close-color': offCanvasColors.close } : {}),
        ...(dropdownBorder ? { '--divonex-dropdown-border': dropdownBorder } : {}),
        ...(dropdownBorderRadius ? { '--divonex-dropdown-border-radius': dropdownBorderRadius } : {})
    };

    useEffect(() => {
        setAttributes({ blockStyle: { customCSS } });
    }, [alignment, colors, offCanvasMenuColors, offCanvasColors]);

    const navMenus = (typeof divonex !== 'undefined' && divonex.menus)
        ? divonex.menus
        : [
              {
                  label: __('No menus found', 'divonex'),
                  value: 'no-menus'
              }
          ];

    return (
        <>
            <InspectorControls group="settings">
                <PanelBody>
                    <SelectControl
                        label={__('Select Menu', 'divonex')}
                        value={selectedMenu}
                        options={navMenus}
                        onChange={newValue => setAttributes({ selectedMenu: newValue })}
                    />
                    <p className="divonex-note">
                        {__('To create navigation menus, ', 'divonex')}
                        <a href="/wp-admin/nav-menus.php">{__('click here', 'divonex')}</a>
                    </p>
                    <ToggleGroupControl
                        label={__('Alignment', 'divonex')}
                        value={alignment}
                        isBlock
                        __nextHasNoMarginBottom
                        __next40pxDefaultSize
                        onChange={newValue => setAttributes({ alignment: newValue })}
                    >
                        {justifyOptions.map(option => (
                            <ToggleGroupControlOption key={option.value} value={option.value} label={option.label} />
                        ))}
                    </ToggleGroupControl>

                    <ToggleGroupControl
                        label={__('Off Canvas Menu', 'divonex')}
                        value={offCanvasMenu}
                        isBlock
                        __nextHasNoMarginBottom
                        __next40pxDefaultSize
                        onChange={newValue => setAttributes({ offCanvasMenu: newValue })}
                    >
                        {stacks.map(option => (
                            <ToggleGroupControlOption key={option.value} value={option.value} label={option.label} />
                        ))}
                    </ToggleGroupControl>
                    {offCanvasMenu !== 'no-stack' && (
                        <SelectControl
                            label={__('Position', 'divonex')}
                            value={offCanvasPosition}
                            options={[
                                {
                                    label: __('Right', 'divonex'),
                                    value: 'right'
                                },
                                {
                                    label: __('Left', 'divonex'),
                                    value: 'left'
                                }
                            ]}
                            onChange={newValue => setAttributes({ offCanvasPosition: newValue })}
                        />
                    )}
                </PanelBody>
            </InspectorControls>
            <InspectorControls group="styles">
                <PanelColorSettings
                    title={__('Normal Menu', 'divonex')}
                    initialOpen={false}
                    colorSettings={[
                        {
                            label: __('Text', 'divonex'),
                            value: colors.text,
                            onChange: newValue => setAttributes({ colors: { ...colors, text: newValue } })
                        },
                        {
                            label: __('Background', 'divonex'),
                            value: colors.bg,
                            onChange: newValue => setAttributes({ colors: { ...colors, bg: newValue } })
                        },
                        {
                            label: __('Text Hover', 'divonex'),
                            value: colors.textHover,
                            onChange: newValue => setAttributes({ colors: { ...colors, textHover: newValue } })
                        },
                        {
                            label: __('Background Hover', 'divonex'),
                            value: colors.bgHover,
                            onChange: newValue => setAttributes({ colors: { ...colors, bgHover: newValue } })
                        }
                    ]}
                />
                <PanelBody>
                    <TextControl
                        label={__('Submenu Container Border Radius', 'divonex')}
                        value={dropdownBorderRadius}
                        onChange={newValue => setAttributes({ dropdownBorderRadius: newValue })}
                        placeholder="5px"
                    />
                </PanelBody>
                <PanelColorSettings
                        title={__('Sub Menu Container', 'divonex')}
                        initialOpen={false}
                        colorSettings={[
                            {
                                label: __('Border Color', 'divonex'),
                                value: dropdownBorder,
                                onChange: newValue => setAttributes({ dropdownBorder: newValue })
                            }
                        ]}
                    />
                {offCanvasMenu !== 'no-stack' && (
                    <>
                        <PanelColorSettings
                            title={__('Off Canvas', 'divonex')}
                            initialOpen={false}
                            colorSettings={[
                                {
                                    label: __('Overlay Background', 'divonex'),
                                    value: offCanvasColors.overlayBg,
                                    onChange: newValue => setAttributes({ offCanvasColors: { ...offCanvasColors, overlayBg: newValue } })
                                },
                                {
                                    label: __('Bars', 'divonex'),
                                    value: offCanvasColors.barsColor,
                                    onChange: newValue => setAttributes({ offCanvasColors: { ...offCanvasColors, barsColor: newValue } })
                                },
                                {
                                    label: __('Close Button Color', 'divonex'),
                                    value: offCanvasColors.close,
                                    onChange: newValue => setAttributes({ offCanvasColors: { ...offCanvasColors, close: newValue } })
                                }
                            ]}
                        />
                        <PanelColorSettings
                            title={__('Off Canvas Menu', 'divonex')}
                            initialOpen={false}
                            colorSettings={[
                                {
                                    label: __('Overlay Background', 'divonex'),
                                    value: offCanvasMenuColors.overlayBg,
                                    onChange: newValue =>
                                        setAttributes({ offCanvasMenuColors: { ...offCanvasMenuColors, overlayBg: newValue } })
                                },
                                {
                                    label: __('Text', 'divonex'),
                                    value: offCanvasMenuColors.text,
                                    onChange: newValue => setAttributes({ offCanvasMenuColors: { ...offCanvasMenuColors, text: newValue } })
                                },
                                {
                                    label: __('Background', 'divonex'),
                                    value: offCanvasMenuColors.bg,
                                    onChange: newValue => setAttributes({ offCanvasMenuColors: { ...offCanvasMenuColors, bg: newValue } })
                                },
                                {
                                    label: __('Text Hover', 'divonex'),
                                    value: offCanvasMenuColors.textHover,
                                    onChange: newValue =>
                                        setAttributes({ offCanvasMenuColors: { ...offCanvasMenuColors, textHover: newValue } })
                                },
                                {
                                    label: __('Background Hover', 'divonex'),
                                    value: offCanvasMenuColors.bgHover,
                                    onChange: newValue =>
                                        setAttributes({ offCanvasMenuColors: { ...offCanvasMenuColors, bgHover: newValue } })
                                }
                            ]}
                        />
                    </>
                )}
            </InspectorControls>
            <div
                {...useBlockProps({
                    style: customCSS
                })}
            >
                <ServerSideRender block="divonex/navigation" attributes={attributes} />
            </div>
        </>
    );
}
