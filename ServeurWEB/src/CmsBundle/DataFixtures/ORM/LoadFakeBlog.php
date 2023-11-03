<?php

namespace CmsBundle\DataFixtures\ORM;

use CmsBundle\Entity\Article;
use CmsBundle\Entity\Category;
use CmsBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use joshtronic\LoremIpsum;

class LoadFakeBlog implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lipsum = new LoremIpsum();

        $categorys = [];
        $tags = [];

        for($i=0; $i<5; $i++) {
            $category = new Category();
            $category->setName($lipsum->words(3));
            $category->setExcerpt($lipsum->sentence());
            $manager->persist($category);
            $categorys[] = $category;
        }

        for($i=0; $i<15; $i++) {
            $tag = new Tag();
            $tag->setName($lipsum->words(2));
            $tag->setExcerpt($lipsum->sentence());
            $manager->persist($tag);
            $tags[] = $tag;
        }

        for($i=0; $i<100; $i++) {
            $article = new Article();
            $article->setName($lipsum->words(4));
            $article->setExcerpt($lipsum->sentence());
            $article->setContent($lipsum->paragraphs(4, 'p'));
            $categoryI = rand(0, sizeof($categorys)-1);
            $article->setCategory($categorys[$categoryI]);
            $tag1I = rand(7, sizeof($tags)-1);
            $article->addTag($tags[$tag1I]);
            $tag2I = rand(0, 6);
            $article->addTag($tags[$tag2I]);
            $manager->persist($article);
        }

        // @todo => comment pour la prod
        $manager->flush();
    }
}