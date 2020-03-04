<?php namespace Visiosoft\ProfileModule;

use Anomaly\FilesModule\Disk\Contract\DiskRepositoryInterface;
use Anomaly\FilesModule\Folder\Contract\FolderRepositoryInterface;
use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Visiosoft\ProfileModule\Seed\UsersFieldsSeeder;

class ProfileModuleSeeder extends Seeder
{

    /**
     * The disk repository.
     *
     * @var DiskRepositoryInterface
     */
    protected $disks;

    /**
     * The folder repository.
     *
     * @var FolderRepositoryInterface
     */
    protected $folders;

    /**
     * Create a new FolderSeeder instance.
     *
     * @param DiskRepositoryInterface   $disks
     * @param FolderRepositoryInterface $folders
     */
    public function __construct(DiskRepositoryInterface $disks, FolderRepositoryInterface $folders)
    {
        parent::__construct();

        $this->disks   = $disks;
        $this->folders = $folders;
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        // Users Fields Seeder
        $this->call(UsersFieldsSeeder::class);

        if (is_null($this->folders->findBy('slug', 'favicon'))) {
            $disk = $this->disks->findBySlug('local');

            $this->folders->create([
                'en'            => [
                    'name'        => 'Favicon',
                    'description' => 'A folder for Favicon.',
                ],
                'slug'          => 'favicon',
                'disk'          => $disk,
                'allowed_types' => [
                    'ico','png',
                ],
            ]);
        };
    }
}