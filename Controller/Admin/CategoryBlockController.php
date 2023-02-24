<?php

namespace Plugin\Test\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\Test\Form\Type\Admin\ConfigType;
use Plugin\Test\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Eccube\Repository\CategoryRepository;
use Eccube\Event\EventArgs;
use Plugin\Test\Entity\CategoryBlock;
use Eccube\Form\Type\Admin\CategoryType;


class CategoryBlockController extends AbstractController
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

        /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        ConfigRepository $configRepository,
        CategoryRepository $categoryRepository
        )
    {
        $this->configRepository = $configRepository;
        $this->categoryRepository = $categoryRepository;
    }

    // /**
    //  * @Route("/%eccube_admin_route%/test/config", name="test_admin_config")
    //  * @Template("@Test/admin/config.twig")
    //  */
    // public function index(Request $request)
    // {
    //     $Config = $this->configRepository->get();
    //     $form = $this->createForm(ConfigType::class, $Config);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $Config = $form->getData();
    //         $this->entityManager->persist($Config);
    //         $this->entityManager->flush();
    //         $this->addSuccess('登録しました。', 'admin');

    //         return $this->redirectToRoute('test_admin_config');
    //     }

    //     return [
    //         'form' => $form->createView(),
    //     ];
    // }
    /**
     * 
     * @Route("/%eccube_admin_route%/product/category/{parent_id}/blockedit", requirements={"parent_id" = "\d+"}, name="admin_product_category_block_edit", methods={"GET", "POST"})
     * @Template("@Test/admin/category_block_edit.twig")
     */
    public function categoryBlockEdit($parent_id, Request $request)
    {
        $Category = $this->categoryRepository->find($parent_id);
        $CategoryBlocks = $this->entityManager->getRepository(CategoryBlock::class)->findBy(["Category" => $Category]);
        foreach ($CategoryBlocks as $CategoryBlock) {
            $this->entityManager->remove($CategoryBlock);
            $this->entityManager->flush();
        }
        $c_name = $Category["name"];
        $builder = $this->formFactory->createBuilder(CategoryType::class, $Category);
        $form = $builder->getForm();
        $form->handleRequest($request);
        $Category->setName($c_name);
        $Blocks = $form->get('Block')->getData();

        foreach($Blocks as $Block) {
            $CategoryBlock = new CategoryBlock();
            $CategoryBlock 
                ->setCategoryId($Category->getId())
                ->setBlockId($Block->getId())
                ->setCategory($Category)
                ->setBlock($Block);
            $this->entityManager->persist($CategoryBlock);
            $this->entityManager->flush();

        }
        $this->addSuccess('admin.common.save_complete', 'admin');
        return $this->redirectToRoute('admin_product_category_show', ['parent_id' => $Category->getId()]);


        // return new Response('Hello sample page !'.$parent_id);
    }
}
