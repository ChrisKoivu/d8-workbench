<?php

namespace Drupal\shurly\Plugin\views\field;

use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\ViewExecutable;
use Drupal\views\Plugin\views\display\DisplayPluginBase;

/**
 * Field handler to provide a link to the short URL entry.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("shurly_link_edit")
 */
class ShurlyLinkEdit extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);

    $this->additional_fields['uid'] = 'uid';
    $this->additional_fields['active'] = 'active';
    $this->additional_fields['rid'] = 'rid';
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    
    $options['text'] = array('default' => '', 'translatable' => TRUE);
    
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => t('Text to display'),
      '#default_value' => $this->options['text'],
    );

    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->ensureMyTable();
    $this->addAdditionalFields();
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $user = \Drupal::currentUser();
    $uid = $this->getValue($values, 'uid');
    $active = $this->getValue($values, 'active');
    if (!$active) {
      return t('deactivated');
    }
    // only allow the user to view the link if they can actually edit
    if (\Drupal::currentUser()->hasPermission('Administer short URLs') || (\Drupal::currentUser()->hasPermission('Edit own URLs') && $uid == $user->uid)) {
      $text = !empty($this->options['text']) ? $this->options['text'] : t('edit');
      $rid = $this->getValue($values, 'rid');
      return link::fromTextAndUrl($text, Url::fromUri('internal:/shurly/edit/'.$rid, ['query' => \Drupal::service('redirect.destination')->getAsArray()]))->toString();
    }
  }
}
