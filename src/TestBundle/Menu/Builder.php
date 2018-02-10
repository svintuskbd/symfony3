<?php
namespace TestBundle\Menu;

use AppBundle\Entity\Post;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'homepage_blog'));

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        /** @var Post $blog */
        $blog = $em->getRepository('AppBundle:Post')->find(10);

        $menu->addChild('Latest Blog Post', array(
            'route' => 'article_show',
            'routeParameters' => array('slug' => $blog->getSlug())
        ));

        // create another menu item
        $menu->addChild('About Me', array('route' => 'homepage_blog'));
        // you can also add sub level's to your menu's as follows
        $menu['About Me']->addChild('Admin', array('route' => 'sonata_admin_dashboard'));

        // ... add more children

        return $menu;
    }
}