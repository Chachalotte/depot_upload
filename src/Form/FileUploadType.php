<?php
// src/Form/FileUploadType.php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

use App\Repository\CategoryRepository;
use App\Entity\Category;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FileUploadType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder
       
        ->add('Titre', TextType::class, [
          'label' => false,
          'required' => true
        ])
        ->add('Description', CKEditorType::class, [
          'label' => false,
          'required' => true,
          'config' => array(
            'uiColor' => '#ffffff',
            //...
        ),
        ])
        ->add('Lien_1', TextType::class, [
          'label' => false
        ])
        ->add('Lien_2', TextType::class, [
          'label' => false
        ])
        ->add('upload_file', FileType::class, [
          'label' => false,
          'mapped' => false, // Tell that there is no Entity to link
          'required' => true,
          'constraints' => [
            new File([ 
              'mimeTypes' => [ // We want to let upload only txt, csv or Excel files
                'video/x-msvideo',
                'video/mp4',
                'image/gif',
                'image/png',
                'image/jpeg',
              ],
              'mimeTypesMessage' => "Merci de n'upload qu'une vidéo ou une image.",
            ])
          ],
        ])
        ->add('categorie', EntityType::class, [
          'class' => Category::class,
          'query_builder' => function (CategoryRepository $cr) {
            return $cr->createQueryBuilder('c')
                ->orderBy('c.category_name', 'ASC');
        },
        'choice_label' => 'category_name',
        'label' => false,

        ])
        ->add('send', SubmitType::class); // We could have added it in the view, as stated in the framework recommendations
  }
}