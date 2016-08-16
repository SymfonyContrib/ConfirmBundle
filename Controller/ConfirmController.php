<?php

namespace SymfonyContrib\Bundle\ConfirmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SymfonyContrib\Bundle\ConfirmBundle\Form\ConfirmForm;

/**
 * Confirmation controller.
 *
 * Forward requests to this controller:action to confirm an action.
 */
class ConfirmController extends Controller
{
    public function confirmAction(Request $request, array $options = [])
    {
        $form = $this->createForm(ConfirmForm::class, null, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Allow for several confirm action methods.
            // @see http://php.net/manual/en/language.types.callable.php
            if (is_callable($options['confirm_action'])) {
                return call_user_func($options['confirm_action'], $options['confirm_action_args']);
            } else {
                throw new \Exception('Confirm action not callable.');
            }
        }

        return $this->render('ConfirmBundle:Confirm:confirm.html.twig', [
            'form'    => $form->createView(),
            'options' => $options,
        ]);
    }
}
