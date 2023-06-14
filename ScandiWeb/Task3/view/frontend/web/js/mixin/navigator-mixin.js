/**
 * ScandiWeb_Task3 Module
 *
 * @category  ScandiWeb
 * @package   ScandiWeb_Task3
 * @author    Dawood Gondal
 */

define([
    'jquery',
    'ko',
    'mage/utils/wrapper',
    'mage/url'
], function ($, ko, wrapper, urlBuilder) {
    'use strict';

    return function (stepNavigator) {
        stepNavigator.next = wrapper.wrap(stepNavigator.next, function (originalAction) {
            window.location.href = urlBuilder.build('checkout/cart/index');
        });

        return stepNavigator;
    };
});
