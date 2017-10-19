<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("product/create")
     */
    public function createAction()
    {
        $category = new Category();
        $category->setTitle('Computer Peripherals');

        $product = new Product();
        $product->setTitle('Keyboard');
        $product->setPrice('19.19');
        $product->setActive(true);

        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response(
            '<html><body>Saved new product with id: ' . $product->getId()
            . ' and new category with id: ' . $category->getId() . '</body></html>'
        );
    }

    /**
     * @Route("product/{id}/delete")
     * @ParamConverter("product", class="AppBundle:Product")
     */
    public function deleteAction(Product $product = null)
    {
        if (null !== $product) {
            $product_id = $product->getId();
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();

            return new Response(
                '<html><body>Deleted product with id: '.$product_id.'</body></html>'
            );
        }

        return new Response('<html><body>Product not found</body></html>', 404);
    }
}
