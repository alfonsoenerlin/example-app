WAMEcommerceBundle Configuration:
==================================

wam_ecommerce:

    class:
        product: EcommerceBundle\Model\Product
        cart: EcommerceBundle\Model\Cart
        cart_line: EcommerceBundle\Model\CartLine
        order: EcommerceBundle\Model\Order
        order_line: EcommerceBundle\Model\OrderLine
    manager:
        product: EcommerceBundle\Manager\ProductManager
        cart: EcommerceBundle\Manager\CartManager
        cart_line: EcommerceBundle\Manager\CartLineManager
        
    admin:
        product:
            class: EcommerceBundle\Admin\ProductAdmin
            controller: SonataAdminBundle:CRUD
            translation: SonataAdminBundle
        cart:
            class: EcommerceBundle\Admin\CartAdmin
            controller: SonataAdminBundle:CRUD
            translation: SonataAdminBundle
        cart_line:
            class: EcommerceBundle\Admin\CartLineAdmin
            controller: SonataAdminBundle:CRUD
            translation: SonataAdminBundle
            
        purchasable_mapping:
            #EcommerceBundle\Entity\MyPurchasable should extends AbastractPurchasableClass
            myPurchasableEntity: {key: MPE, name: My Purchasable, class: EcommerceBundle\Entity\MyPurchasable}
    
    order_state_machine:
        states:
            - pending_payment
            - paid
        transitions:
            pay:
                from: [pending_payment]
                to: paid
                
    model_manager_name: default
    orm_enabled: true
