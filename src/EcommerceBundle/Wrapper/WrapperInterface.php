<?php

namespace EcommerceBundle\Wrapper;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
interface WrapperInterface
{
    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     */
    public function get();

    /**
     * Clean loaded object in order to reload it again.
     */
    public function clean();
}
