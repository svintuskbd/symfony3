<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ExampleAdmin extends AbstractAdmin
{
    /**
     * @var TokenStorage
     */
    protected $securityTokenStorage;

    /**
     * @var string
     */
    protected $baseRouteName = 'admin_app_profile';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'profile';

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'firstName',
        '_per_page' => 50,
    ];

    protected $maxPerPage = 50;
    protected $perPageOptions = [50, 100, 200];

    /**
     * UserAdmin constructor.
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param $securityTokenStorage
     */
    public function __construct($code, $class, $baseControllerName, $securityTokenStorage)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->securityTokenStorage = $securityTokenStorage;
    }

    /**
     * Set Template
     */
    public function configure()
    {
        $this->setTemplate('edit', 'FrontendBundle:CRUD:user_profile_edit_form.html.twig');
    }

    /**
     * Set Custom Route
     *
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
//        $collection->remove('list');
        $collection->remove('delete');
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    /**
     * Fields to be shown on create/edit forms
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Profile')
            ->add(
                'firstName',
                'text', [
                    'required' => false,
                    'label' => 'First name',
                ]
            )
            ->add(
                'lastName',
                'text', [
                    'required' => false,
                    'label' => 'Last name',
                ]
            )
            ->add(
                'email',
                'email', [
                    'required' => true,
                    'label' => 'Email',
                ]
            )
            ->add(
                'jobFunction',
                'text', [
                    'required' => false,
                    'label' => 'Job function',
                ]
            )
            ->add(
                'jobTitle',
                'text', [
                    'required' => false,
                    'label' => 'Job title',
                ]
            )
            ->add(
                'phone',
                'text', [
                    'required' => false,
                    'label' => 'Phone',
                ]
            )
            ->add(
                'pushNotify',
                null, [
                    'required' => false,
                    'label' => 'Push notify',
                ]
            )
            ->add(
                'emailNotify',
                null, [
                    'required' => false,
                    'label' => 'Email notify',
                ]
            )
            ->add(
                'password',
                'repeated',
                [
                    'type' => 'password',
                    'first_name' => 'password',
                    'first_options' => ['label' => "Password"],
                    'second_name' => 'confirmation',
                    'second_options' => ['label' => 'Password confirmation'],
                    'invalid_message' => 'Password and Password confirmation must match.',
                    'required' => false,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'firstName',
                null, [
                    'label' => 'User name',
                    'show_filter' => true,
                ]
            )
            ->add(
                'lastName',
                null, [
                    'label' => 'Last name',
                    'show_filter' => true,
                ]
            )
            ->add(
                'email',
                null, [
                    'label' => 'Email',
                    'show_filter' => true,
                ]
            )
            ->add(
                'jobFunction',
                null, [
                    'label' => 'Job function',
                    'show_filter' => true,
                ]
            )
            ->add(
                'jobTitle',
                null, [
                    'label' => 'Job title',
                    'show_filter' => true,
                ]
            )
            ->add(
                'phone',
                null, [
                    'label' => 'Phone',
                    'show_filter' => true,
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier(
                'firstName',
                null, [
                    'label' => 'User name',
                ]
            )
            ->addIdentifier(
                'lastName',
                null, [
                    'label' => 'Last name',
                ]
            )
            ->addIdentifier(
                'email',
                null, [
                    'label' => 'Email',
                ]
            )
            ->addIdentifier(
                'jobFunction',
                null, [
                    'label' => 'Job function',
                ]
            )
            ->addIdentifier(
                'jobTitle',
                null, [
                    'label' => 'Job title',
                ]
            )
            ->addIdentifier(
                'phone',
                null, [
                    'label' => 'Phone',
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add(
                'firstName',
                null, [
                    'label' => 'User name',
                ]
            )
            ->add(
                'lastName',
                null, [
                    'label' => 'Last name',
                ]
            )
            ->add(
                'email',
                null, [
                    'label' => 'Email',
                ]
            )
            ->add(
                'jobFunction',
                null, [
                    'label' => 'Job function',
                ]
            )
            ->add(
                'jobTitle',
                null, [
                    'label' => 'Job title',
                ]
            )
            ->add(
                'phone',
                null, [
                    'label' => 'Phone',
                ]
            )
        ;
    }
}
