<?php

namespace MauticPlugin\ContactHashBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\EmailBundle\EventListener\MatchFilterForLeadTrait;
use Mautic\LeadBundle\Entity\LeadList;
use Mautic\LeadBundle\Event\LeadEvent;
use Mautic\LeadBundle\LeadEvents;
use Mautic\LeadBundle\Model\LeadModel;
//use Mautic\PluginBundle\Helper\IntegrationHelper;
//use Symfony\Component\DependencyInjection\ContainerInterface;

class ContactListener extends CommonSubscriber
{

    use MatchFilterForLeadTrait;

    private $leadModel;

    /**
     * ButtonSubscriber constructor.
     *
     * @param IntegrationHelper $helper
     * @param ContainerInterface $container
     */
    public function __construct(
        LeadModel $leadModel
    )
    {
        $this->leadModel     = $leadModel;
    }

    public static function getSubscribedEvents()
    {
        return [
            LeadEvents::LEAD_POST_SAVE      => ['onLeadPostSave', 0],
        ];
    }

    public function onLeadPostSave(LeadEvent $event)
    {
        $config = $event->getConfig();
        $lead = $event->getLead(); // entity

        //$leadFields = $lead->getFields();
        //$leadFields['hash'] = hash('sha256', $lead->getEmail());
        //$lead->setFields($leadFields);

        $lead->addUpdatedField('hash', hash('sha256', $lead->getEmail()));

        $this->leadModel->setFieldValues($lead);
        $this->leadModel->saveEntity($lead);
    }

}
