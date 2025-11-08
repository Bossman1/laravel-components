<?php

namespace NickKh\Components\Commands;

use Illuminate\Console\Command;

class PostInstallSetup extends Command
{
    protected $signature = 'nickkh:setup';
    protected $description = 'Merge package.json and run npm install in the host project';

    public function handle()
    {
        $this->info('✅ Merging npm dependencies into project package.json...');

        // Run your existing merge command
        $this->call('nickkh:merge-packagejson');

        $this->info('✅ Running npm install in project root...');
        $cwd = base_path();
        $result = null;
        $output = null;

        exec('cd ' . escapeshellarg($cwd) . ' && npm install 2>&1', $output, $result);

        if ($result === 0) {
            $this->info('✅ npm install completed successfully.');
        } else {
            $this->error('❌ npm install failed. Output:');
            $this->line(implode("\n", $output));
        }
    }
}
