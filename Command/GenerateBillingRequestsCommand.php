<?php

namespace Vespolina\BillingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Vespolina\Entity\Pricing\PricingContext;

class GenerateBillingRequestsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('vespolina:billing:requests:generate')
            ->setDescription('Generate billing requests based on existing billing agreements.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $billingManager = $this->getContainer()->get('vespolina_billing.billing_manager');

        $pricingContext = new PricingContext();
        $pricingContext->set('endDate', new \DateTime());

        $billingAgreements = $billingManager->findBillingAgreements($pricingContext);

        foreach ($billingAgreements as $billingAgreement) {
            $billingRequest = $billingManager->generateBillingRequest($billingAgreement);
            $billingManager->updateBillingRequest($billingRequest);

            $output->writeln("[%s]Billing request with id '%s' created.",
                $billingRequest->getCreatedAt()->format('Y-m-d H:i:s'),
                $billingRequest->getId()
            );
        }
    }
}
