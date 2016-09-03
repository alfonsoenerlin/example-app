<?php

namespace EcommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use PaymentSuite\PaymentCoreBundle\Event\Abstracts\AbstractPaymentEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use WAM\Bundle\CoreBundle\Service\Mailer;
use EcommerceBundle\Manager\Interfaces\CustomerManagerInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;

/**
 * Class CreateCustomerEventListener.
 */
class CreateCustomerEventListener
{
    /**
     * @var ObjectManager
     *
     * Order object manager
     */
    private $orderObjectManager;

    /**
     * @var CustomerManagerInterface
     *
     * Customer manager
     */
    private $customerManager;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $senderAddress;

    /**
     * Construct method.
     *
     * @param ObjectManager            $orderObjectManager Order object manager
     * @param CustomerManagerInterface $customerManager    Customer manager
     * @param UserManagerInterface     $userManager        User manager
     * @param TokenStorageInterface    $tokenStorage
     * @param Mailer                   $mailer
     * @param string                   $template
     * @param string                   $senderAddress
     */
    public function __construct(
        ObjectManager $orderObjectManager,
        CustomerManagerInterface $customerManager,
        UserManagerInterface $userManager,
        TokenStorageInterface $tokenStorage,
        Mailer $mailer,
        $template,
        $senderAddress
    ) {
        $this->orderObjectManager = $orderObjectManager;
        $this->customerManager = $customerManager;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
        $this->mailer = $mailer;
        $this->template = $template;
        $this->senderAddress = $senderAddress;
    }

    /**
     * Create a new Customer if is null.
     *
     * @param AbstractPaymentEvent $event
     */
    public function createCustomer(AbstractPaymentEvent $event)
    {
        /*
         * @var OrderInterface
         */
        $order = $event
            ->getPaymentBridge()
            ->getOrder();

        if ($order->getCustomer() instanceof CustomerInterface) {
            return;
        }

        /*
         * @var AddressBillableInterface
         */
        $address = $order->getBillingAddress();

        if (!is_null($this->userManager->findUserByUsernameOrEmail($address->getEmail()))) {
            return;
        }

        /*
         * @var CustomerInterface
         */
        $customer = $this->customerManager->create();
        $customer
            ->setEmail($address->getEmail())
            ->setUsername($address->getEmail())
            ->setPlainPassword(uniqid())
            ->setEnabled(true)
        ;

        $this->customerManager->save($customer);

        $order->setCustomer($customer);
        $this->orderObjectManager->flush($order);

        $token = new UsernamePasswordToken($customer, null, 'main', $customer->getRoles());
        $this->tokenStorage->setToken($token);

        $this->notifyNewUser($customer);
    }

    /**
     * @param $user
     *
     * @throws \Exception
     */
    protected function notifyNewUser($user)
    {
        $this->mailer->sendEmail(
            $user->getEmail(),
            'New User created',
            array('user' => $user),
            $this->template,
            $this->senderAddress
        );
    }
}
