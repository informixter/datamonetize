<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class Products
 *
 * @property \App\Products $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Products extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = "Продукты";

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::image('image_url', 'Изображение'),
            AdminColumn::text('level_1', 'Категория уровень 1'),
            AdminColumn::text('level_2', 'Категория уровень 2'),
            AdminColumn::text('level_3', 'Категория уровень 3'),
            AdminColumn::text('name', 'Название'),
            AdminColumn::text('price', 'Цена'),
            AdminColumn::boolean('sale', 'Скидка'),
            AdminColumn::text('sale_percent', 'Скидка в %'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;
        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name', 'Name')
                    ->required(),
                AdminFormElement::text('level_1', 'Категория уровень 1')->required(),
                AdminFormElement::text('level_2', 'Категория уровень 2')->required(),
                AdminFormElement::text('level_3', 'Категория уровень 3')->required(),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::text('price', 'Цена')->required(),
                AdminFormElement::text('price_old', 'Старая цена')->required(),
                AdminFormElement::checkbox('sale', 'Наличие скидки'),
                AdminFormElement::text('sale_percent', 'Процент скидки'),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('key', 'Поисковый ключ')->required(),
            ]),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
