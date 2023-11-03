<?php



namespace CoreBundle\Twig;

use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\MediaBundle\Model\MediaInterface;

class MediaImagineExtension extends \Twig_Extension {

	protected $mediaManager;
	protected $liip_imagine;
	protected $sonata_media;

	public function __construct(ManagerInterface $mediaManager, $liip_imagine, $sonata_media) {
		$this->mediaManager = $mediaManager;
		$this->liip_imagine = $liip_imagine;
		$this->sonata_media = $sonata_media;
		
	}

	public function getFilters() {
		return array(
			new \Twig_SimpleFilter('image', array($this, 'imageFilter'), array('is_safe' => array('all'))),
			new \Twig_SimpleFilter('liip', array($this, 'pathFilter')),
		);
	}

	public function pathFilter($media, $filter = null, array $runtimeConfig = array()) {
		$media = $this->getMedia($media);

		if (!$media) {
			return '';
		}

		if ($filter) {
			$provider = $this->sonata_media->getMediaService()->getProvider($media->getProviderName());
			$url = $provider->getReferenceImage($media);
			return $this->liip_imagine->filter($url, $filter, $runtimeConfig);
		} else {
			return $this->sonata_media->path($media, "reference");
		}
	}

	public function imageFilter($media, $filter = null, array $runtimeConfig = array()) {
		$media = $this->getMedia($media);

		if (!$media) {
			return '';
		}

		if ($filter) {
			$provider = $this->sonata_media->getMediaService()->getProvider($media->getProviderName());
			$url = $provider->getReferenceImage($media);
			$src = $this->liip_imagine->filter($url, $filter, $runtimeConfig);
	//		return "<img src='".$src."' height='".$media->getHeight()."' width='".$media->getWidth()."' alt='".$media->getName()."' />";
			return "<img src='".$src."' alt='".$media->getName()."' />";
		} else {
			return $this->sonata_media->media($media, "reference", $runtimeConfig);
		}
	}

	private function getMedia($media) {
		if (!$media instanceof MediaInterface && strlen($media) > 0) {
			$media = $this->mediaManager->findOneBy(array(
				'id' => $media
			));
		}
		if (!$media instanceof MediaInterface) {
			return false;
		}
		if ($media->getProviderStatus() !== MediaInterface::STATUS_OK) {
			return false;
		}
		return $media;
	}


	
	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'sonata_media_imagine';
	}

}