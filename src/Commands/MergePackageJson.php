<?php

namespace NickKh\Components\Commands;

use Illuminate\Console\Command;

class MergePackageJson extends Command
{
    protected $signature = 'nickkh:merge-packagejson';
    protected $description = 'Merge NickKh Components npm devDependencies into the project package.json';

    public function handle()
    {
        $targetPath = base_path('package.json');
        $stubPath = __DIR__ . '/../../stubs/package.json';

        if (!file_exists($targetPath)) {
            $this->error('No package.json found in project root. Create one (npm init) and try again.');
            return 1;
        }

        if (!file_exists($stubPath)) {
            $this->error('Stub package.json not found in package.');
            return 1;
        }

        $project = json_decode(file_get_contents($targetPath), true);
        $stub = json_decode(file_get_contents($stubPath), true);

        if (!is_array($project)) {
            $this->error('Could not parse project package.json.');
            return 1;
        }

        $projectDevDeps = $project['devDependencies'] ?? [];
        $stubDevDeps = $stub['devDependencies'] ?? [];

        // Merge without overwriting existing versions if present.
        foreach ($stubDevDeps as $pkg => $version) {
            if (!isset($projectDevDeps[$pkg])) {
                $projectDevDeps[$pkg] = $version;
            }
        }

        $project['devDependencies'] = $projectDevDeps;

        file_put_contents(
            $targetPath,
            json_encode($project, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL
        );

        $this->info('✅ NickKh: devDependencies merged into package.json.');
        $this->line('Run: npm install');
        $this->line('Then: npm run dev (or npm run build)');
        return 0;
    }
}
