<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use Faker\Factory;
use App\Entity\Comment;
use App\DataFixtures\TagFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Tag;

class ArticleFixture extends BaseFixture implements DependentFixtureInterface
{
    private static $articleTitles = [
      'Why Asteroids Taste Like Bacon',
      'Life on Planet Mercury: Tan, Relaxing and Fabulous',
      'Light Speed Travel: Fountain of Youth or Fallacy',
    ];
    private static $articleImages = [
      'asteroid.jpeg',
      'mercury.jpeg',
      'lightspeed.png',
    ];
    private static $articleAuthors = [
      'Mike Ferengi',
      'Amy Oort',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {
            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent("Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?");

            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setImageFileName($this->faker->randomElement(self::$articleImages));

            $tags = $this->getRandomReferences(Tag::class, $this->faker->numberBetween(0, 5));

            foreach ($tags as $tag) {
              $article->addTag($tag);
            }
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
        TagFixture::class
      ];
    }
}
