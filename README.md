# 🔒 Symfony Password Exposed Bundle

This package provides a Symfony bundle that checks if a password has been exposed in a data breach. It uses the haveibeenpwned.com passwords API via the [`divineomega/password_exposed`](https://github.com/DivineOmega/password_exposed) library.


## Installation

The `password_exposed` symfony bundle can be easily installed using Composer. Just run the following command from the root of your project.

```
composer require divineomega/symfony-password-exposed-bundle
```

If you have never used the Composer dependency manager before, head to the [Composer website](https://getcomposer.org/) for more information on how to get started.

## Configuration

You can adjust this bundle with some simple configs

```yaml
password_exposed:
    enable: true // optional; for example disable this in dev env 
    http_client: null // optional; a custom http client
    cache: cache.app // optional; a custom cache
    cache_lifetime: 2592000 // optional; cache lifetime in seconds
    request_factory: null // optional; a custom request factory. see psr-7
    uri_factory: null // optional; a custom uri factory. see psr-7
```
## Usage

### In a controller

To check if a password has been exposed in a data breach, just pass it to the `isExposed` method.

Here is a basic usage example for a controller:

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DivineOmega\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StandardController extends AbstractController
{

    /** @var PasswordExposedCheckerInterface */
    protected $checker;
    
    /**
     * @param PasswordExposedCheckerInterface $checker
     */
    public function __construct(PasswordExposedCheckerInterface $checker) 
    {
        $this->checker = $checker;
    }
    
    /**
     * @param Request $request
     * @return Response
     */
    public function simpleAction(Request $request): Response
    {
        $password = $request->get('password');
        
        if($this->checker->isExposed($password)) {
            // do something
            // password is exposed
        }
        
        return new Response();
    }
}
```

### As a constraint in a form type

You can also use the `password_exposed` checker in a form type with the help of a constraint.

```php

<?php

namespace App\Form\Type;

use DivineOmega\PasswordExposed\Symfony\Validator\Constraints\PasswordExposed;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;

/**
 * Class RegisterType
 */
class RegisterType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('username', TextType::class, [
            'label'       => 'Username',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('plainPassword', PasswordType::class, [
            'label' => 'Password',
            'constraints'     => [
                new Assert\NotBlank(),
                new PasswordExposed(),
            ],
        ]);
    }


    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

```
