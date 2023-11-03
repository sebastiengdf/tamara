<?php


namespace CoreBundle\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;

class Encode
{

    protected $container;

    /**
     * Encode constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function encode($password)
    {
        return base64_encode(
            mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->container->getParameter('secret')), $password, MCRYPT_MODE_CBC, md5(md5($this->container->getParameter('secret'))))
        );
    }

    public function decode($password)
    {
        return rtrim(
            mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->container->getParameter('secret')), base64_decode($password), MCRYPT_MODE_CBC, md5(md5($this->container->getParameter('secret')))),
            "\0"
        );
    }


}