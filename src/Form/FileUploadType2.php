<?php
// src/Form/FileUploadType2.php
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

class FileUploadType2 extends AbstractType
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
      
        ->add('send', SubmitType::class); // We could have added it in the view, as stated in the framework recommendations
  }
}