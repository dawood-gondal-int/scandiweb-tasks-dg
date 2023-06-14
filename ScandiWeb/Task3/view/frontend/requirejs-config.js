/**
 * ScandiWeb_Task3 Module
 *
 * @category  ScandiWeb
 * @package   ScandiWeb_Task3
 * @author    Dawood Gondal
 */

var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/model/step-navigator': {
                'ScandiWeb_Task3/js/mixin/navigator-mixin': true
            }
        }
    }
};
