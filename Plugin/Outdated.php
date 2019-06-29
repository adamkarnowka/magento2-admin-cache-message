<?php
namespace BrightLights\AdminCacheMessage\Plugin;

class Outdated extends \Magento\AdminNotification\Model\System\Message\CacheOutdated{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $_authorization;

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $_formKey;

    /**
     * Outdated constructor.
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     */
    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorization,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Data\Form\FormKey $formKey
    ) {
        $this->_authorization = $authorization;
        $this->_urlBuilder = $urlBuilder;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_formKey = $formKey;
    }

    /**
     * @return string
     */
    public function getText(){
        $html = parent::getText();
        $html .= __('<br/>Or - you can click here to <a class="refreshCacheLink" type="all" href="%1">refresh all cache types</a> or refresh <a href="%1" class="refreshCacheLink" type="invalidated">just invalidated ones</a>', $this->getRefreshUrl());
        $html .= $this->getFormHtml('all');
        $html .= $this->getFormHtml('invalidated');
        return $html;
    }

    /**
     * @return string
     */
    private function getRefreshUrl(){
        return $this->_urlBuilder->getUrl('adminhtml/cache/massRefresh');
    }

    /**
     * @param string $processingTypes
     * @return string
     */
    private function getFormHtml($processingTypes = 'all'){
        $types = [];
        $html = sprintf('<form id="refresh_all_caches_%s" action="%s" method="POST">', $processingTypes, $this->getRefreshUrl());
        if($processingTypes == 'all'){
            $cacheTypes = $this->_cacheTypeList->getTypes();
        } else {
            $cacheTypes = $this->_cacheTypeList->getInvalidated();
        }

        foreach ($cacheTypes as $type) {
            $types[] = $type->getId();
        }

        $html .= sprintf('<input type="hidden" value="%s" name="types" />', implode(',', $types));
        $html .= sprintf('<input type="hidden" value="types" name="massaction_prepare_key" />');
        $html .= sprintf('<input type="hidden" value="%s" name="form_key" />', $this->_formKey->getFormKey());
        $html.= '</form>';

        $html .= $this->getJsCode();
        return $html;
    }

    private function getJsCode(){
        $code = '<script type="text/javascript">
            require(["jquery","cacheRefresher"],function($){
                
            });
            </script>';

        return $code;
    }
}