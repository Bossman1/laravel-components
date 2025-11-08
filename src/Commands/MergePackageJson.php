<?php

namespace NickKh\Components\Commands;

use Illuminate\Console\Command;

class MergePackageJson extends Command
{
    protected $signature = 'nickkh:merge-packagejson';
    protected $description = 'Merge NickKh Components dependencies into project package.json';

    public function handle()
    {
        $targetPath = base_path('package.json');
        $stubPath = __DIR__ . '/../../stubs/package.json';

        if (!file_exists($targetPath)) {
            $this->error('No package.json found in project root.');
            return;
        }

        $project = json_decode(file_get_contents($targetPath), true);
        $stub = json_decode(file_get_contents($stubPath), true);

        $project['devDependencies'] = array_merge(
            $project['devDependencies'] ?? [],
            $stub['devDependencies'] ?? []
        );

        file_put_contents(
            $targetPath,
            json_encode($project, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        $this->info('✅ Dependencies merged! Now run: npm install && npm run dev');
    }
}
