<?php   
    namespace Drupal\ck_layouts;


    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Core\Layout\LayoutDefault;
    use Drupal\Core\Plugin\PluginFormInterface;

    class MyLayoutClass extends LayoutDefault implements PluginFormInterface {

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return parent::defaultConfiguration() + [
        'extra_classes' => 'Default',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
        $configuration = $this->getConfiguration();
        $form['extra_classes'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Extra classes'),
        '#default_value' => $configuration['extra_classes'],
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
        // any additional form validation that is required
    }

    /**
     * {@inheritdoc}
     */
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
        $this->configuration['extra_classes'] = $form_state->getValue('extra_classes');
    }

    }