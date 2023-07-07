<?php

namespace Drupal\paragraphs_bootstrap_carousel\Plugin\Field\FieldFormatter;

use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\field\FieldConfigInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'paragraphs_table_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "paragraphs_bootstrap_carousel_formatter",
 *   module = "paragraphs_bootstrap_carousel",
 *   label = @Translation("Paragraphs boostrap carousel"),
 *   field_types = {
 *     "entity_reference_revisions"
 *   }
 * )
 */
class ParagraphsBootstrapCarouselFormatter extends EntityReferenceFormatterBase {

  /**
   * The entity display repository.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $entityDisplayRepository;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The file URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * The fields of paragraphs.
   *
   * @var \Drupal\field\Entity\FieldConfig
   */
  protected $fieldsParagraphs;

  /**
   * Constructs a FormatterBase object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entity_display_repository
   *   The entity display repository.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file url generator service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityDisplayRepositoryInterface $entity_display_repository, EntityTypeManagerInterface $entity_type_manager, RendererInterface $renderer, FileUrlGeneratorInterface $file_url_generator) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->entityDisplayRepository = $entity_display_repository;
    $this->entityTypeManager = $entity_type_manager;
    $this->renderer = $renderer;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_display.repository'),
      $container->get('entity_type.manager'),
      $container->get('renderer'),
      $container->get('file_url_generator'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        // Implement default settings.
      'view_mode' => 'default',
      'interval' => 5000,
      'pause' => TRUE,
      'indicators' => TRUE,
      'controls' => TRUE,
      'image' => 'field_image',
      'image_type' => 'original',
      'image_style' => '',
      'caption' => '',
      'link' => 'field_link',
      'wrap' => TRUE,
      'ajax' => FALSE,
      'cdn' => FALSE,
      'custom_class' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritDoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settingForm = [
      'view_mode' => [
        '#type' => 'select',
        '#options' => $this->entityDisplayRepository->getViewModeOptions($this->getFieldSetting('target_type')),
        '#title' => $this->t('View mode'),
        '#default_value' => $this->getSetting('view_mode'),
        '#required' => TRUE,
      ],
      'image' => [
        '#title' => $this->t('Field Image'),
        '#description' => $this->t('Select field image background.'),
        '#type' => 'select',
        '#default_value' => $this->getSettings()['image'],
        '#options' => $this->getConfigurableFields('image'),
        '#required' => TRUE,
      ],
      'image_type' => [
        '#type' => 'select',
        '#title' => $this->t('Image type'),
        '#description' => $this->t('Bootstrap image type for carousel items.'),
        '#options' => [
          'img-default' => $this->t('Image none'),
          'img-fluid' => $this->t('Image fluid'),
          'img-circle' => $this->t('Image circle'),
        ],
        "#empty_option" => $this->t('Original'),
        '#default_value' => $this->getSettings()['image_type'],
      ],
      'image_style' => [
        '#type' => 'select',
        '#title' => $this->t('Image style'),
        '#description' => $this->t('Image style for carousel items. If you will be use the image styles for bootstrap items, you need to set up the same width for the "bootstrap carousel" container.'),
        '#options' => $this->getImagesStyles(),
        "#empty_option" => $this->t('Original image'),
        '#default_value' => $this->getSettings()['image_style'],
      ],
      'caption' => [
        '#title' => $this->t('Field caption'),
        '#description' => $this->t('Select field caption to slides. If not it takes view mode'),
        '#type' => 'select',
        '#default_value' => $this->getSettings()['caption'],
        '#options' => $this->getConfigurableFields([
          'list_string',
          'text',
          'text_long',
          'text_with_summary',
          'string',
          'string_long',
        ]),
        "#empty_option" => $this->t('Render with view mode'),
      ],
      'link' => [
        '#title' => $this->t('Field link on click'),
        '#description' => $this->t('Select field image background.'),
        '#type' => 'select',
        '#default_value' => $this->getSettings()['link'],
        '#options' => $this->getConfigurableFields('link'),
        "#empty_option" => $this->t('Not clickable'),
      ],
      'interval' => [
        '#title' => $this->t('Interval'),
        '#description' => $this->t('The amount of time to delay between automatically cycling an item.'),
        '#type' => 'number',
        '#default_value' => $this->getSettings()['interval'],
      ],
      'pause' => [
        '#title' => $this->t('Pause on mouse hover'),
        '#description' => $this->t('Pauses the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave'),
        '#type' => 'checkbox',
        '#default_value' => $this->getSettings()['pause'],
      ],
      'indicators' => [
        '#title' => $this->t('Show indicators'),
        '#description' => $this->t('that allow to switch on the separate carousel item'),
        '#type' => 'checkbox',
        '#default_value' => $this->getSettings()['indicators'],
      ],
      'controls' => [
        '#title' => $this->t('Show controls'),
        '#description' => $this->t('that allow to switch to the next/prev carousel item'),
        '#type' => 'checkbox',
        '#default_value' => $this->getSettings()['controls'],
      ],
      'wrap' => [
        '#title' => $this->t('Loop'),
        '#type' => 'checkbox',
        '#default_value' => $this->getSettings()['wrap'],
      ],
      /*
      'ajax' => [
      '#title' => $this->t('Load carousel item with ajax'),
      '#description' => $this->t('Use for big image'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSettings()['ajax'],
      ],*/
      'cdn' => [
        '#title' => $this->t('Load bootstrap CDN'),
        '#description' => $this->t('Use if your theme is not base on bootstrap theme'),
        '#type' => 'checkbox',
        '#default_value' => $this->getSettings()['cdn'],
      ],
      'custom_class' => [
        '#title' => $this->t('Set table class'),
        '#type' => 'textfield',
        '#default_value' => $this->getSettings()['custom_class'],
      ],
    ];
    return $settingForm + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    $view_modes = $this->entityDisplayRepository->getViewModeOptions($this->getFieldSetting('target_type'));
    $view_mode = $this->getSetting('view_mode');
    $summary[] = $this->t('Rendered as @view_mode', ['@view_mode' => $view_modes[$view_mode] ?? $view_mode]);
    if (empty($this->fieldsParagraphs)) {
      $this->setFieldsParagraphs();
    }
    if (!empty($this->getSetting('image'))) {
      $summary[] = $this->t('Field image: @image @type @style', [
        '@image' => $this->fieldsParagraphs[$this->getSetting('image')]->getLabel(),
        '@type' => $this->getSetting('image_type'),
        '@style' => $this->getSetting('image_style'),
      ]);
    }
    if (!empty($this->getSetting('caption'))) {
      $summary[] = $this->t('Field caption: @caption', ['@caption' => $this->fieldsParagraphs[$this->getSetting('caption')]->getLabel()]);
    }
    if (!empty($this->getSetting('link'))) {
      $summary[] = $this->t('Field link: @link', ['@link' => $this->fieldsParagraphs[$this->getSetting('link')]->getLabel()]);
    }
    $options = [];
    if (!empty($this->getSetting('interval'))) {
      $options[] = $this->t('Interval : @interval', ['@interval' => $this->getSetting('interval')]);
    }
    if (!empty($this->getSetting('indicators'))) {
      $options[] = $this->t('Indicators');
    }
    if (!empty($this->getSetting('pause'))) {
      $options[] = $this->t('Pause');
    }
    if (!empty($this->getSetting('controls'))) {
      $options[] = $this->t('Controls');
    }
    if (!empty($this->getSetting('wrap'))) {
      $options[] = $this->t('Loop');
    }
    if (!empty($this->getSetting('ajax'))) {
      $options[] = $this->t('Load ajax');
    }
    if (!empty($this->getSetting('cdn'))) {
      $options[] = $this->t('use CDN');
    }
    if (!empty($options)) {
      $summary[] = implode(", ", $options);
    }
    if (!empty($this->getSetting('custom_class'))) {
      $summary[] = $this->t('Custom class: @class', ['@class' => $this->getSetting('custom_class')]);
    }
    return $summary;
  }

  /**
   * {@inheritDoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $setting = $this->getSettings();
    $render = [
      '#id_field_name' => $this->fieldDefinition->getName(),
      '#items' => $this->getCarouselItems($items, $langcode),
      '#settings' => $setting,
      '#theme' => 'paragraphs_bootstrap_carousel',
    ];

    if ($setting['cdn']) {
      $render['#attached'] = [
        'library' => [
          'paragraphs_bootstrap_carousel/bootstrap',
        ],
      ];
    }
    return [$render];
  }

  /**
   * Set field for paragraphs.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function setFieldsParagraphs() {
    $targetType = $this->getFieldSetting('target_type');
    $targetBundle = array_key_first($this->fieldDefinition->getSetting("handler_settings")["target_bundles"]);
    /** @var \Drupal\paragraphs\ParagraphInterface $paragraphs_entity */
    $paragraphs_entity = $this->entityTypeManager->getStorage($targetType)
      ->create(['type' => $targetBundle]);
    $field_definitions = $paragraphs_entity->getFieldDefinitions();
    foreach ($field_definitions as $field_name => $field) {
      if ($field instanceof FieldConfigInterface) {
        $this->fieldsParagraphs[$field_name] = $field;
      }
    }
  }

  /**
   * Return images styles.
   *
   * @return array
   *   Image styles list
   */
  protected function getImagesStyles() {
    $styles = $this->entityTypeManager->getStorage('image_style')
      ->loadMultiple();
    foreach ($styles as $key => $value) {
      $options[$key] = $value->get('label');
    }
    return $options;
  }

  /**
   * Get list of fields.
   */
  protected function getConfigurableFields($type = FALSE) {
    if (empty($this->fieldsParagraphs)) {
      $this->setFieldsParagraphs();
    }
    $listField = [];
    foreach ($this->fieldsParagraphs as $field_name => $field) {
      $listField[$field_name] = $field->getLabel();
      if (!empty($type)) {
        if (!is_array($type) && $type != $field->getType()) {
          unset($listField[$field_name]);
        }
        if (is_array($type) && !in_array($field->getType(), $type)) {
          unset($listField[$field_name]);
        }
      }
    }
    return $listField;
  }

  /**
   * Get the entities which will make up the carousel.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   The field items.
   * @param string $langcode
   *   Language code.
   *
   * @return array
   *   An array of loaded entities.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function getCarouselItems(FieldItemListInterface $items, $langcode) {
    $setting = $this->getSettings();
    $entity_type = $this->fieldDefinition->getFieldStorageDefinition()
      ->getSetting('target_type');
    $entity_storage = $this->entityTypeManager->getStorage($entity_type);
    $entities = [];
    $field_image = $setting["image"];
    $field_link = $setting["link"];
    $field_caption = $setting["caption"];
    $view_mode = $setting['view_mode'];
    foreach ($items as $item) {
      $entity_id = $item->getValue()['target_id'];
      if ($entity_id) {
        $entity = $entity_storage->load($entity_id);
        if ($entity && $entity->access('view') && $entity->hasField($field_image)) {
          $item = new \stdClass();
          $imageField = $entity->get($field_image);

          $item->image_url = $this->fileUrlGenerator->generateAbsoluteString($imageField->entity->getFileUri());
          if (!empty($setting['image_style'])) {
            $imageUrl = $imageField->entity->uri->value;
            $image_style = $setting['image_style'];
            $item->image_url = $this->fileUrlGenerator->transformRelative(
              $this->entityTypeManager->getStorage('image_style')
                ->load($image_style)->buildUrl($imageUrl)
            );
          }

          $item->image_title = $imageField->title;
          $item->image_alt = $imageField->alt;
          if (!empty($field_link)) {
            $linkField = $entity->get($field_link);
            $item->image_link = $linkField->first()->getUrl()->toString();
            $item->caption_title = $linkField->title;
          }

          if (!empty($field_caption)) {
            $item->caption_text = $entity->get($field_caption)->value;
          }
          else {
            $view_builder = $this->entityTypeManager->getViewBuilder(
              $entity->getEntityTypeId()
            );
            $paragraphs_view = $view_builder->view($entity, $view_mode, $langcode);
            $item->caption_text = $this->renderer->render($paragraphs_view);
          }

          $entities[] = $item;
        }
      }
    }
    return $entities;
  }

}
