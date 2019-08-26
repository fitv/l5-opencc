<?php

namespace Mvmx\OpenCC;

use Illuminate\Support\Arr;
use Mvmx\OpenCC\Exceptions\ConfigurationException;
use Mvmx\OpenCC\Exceptions\NeedsExtensionException;

class OpenCC
{
    /**
     * @var array
     */
    protected $odMap = [];

    /**
     * Construct function
     *
     * @return void
     *
     * @throws \Mvmx\OpenCC\Exceptions\NeedsExtensionException
     */
    public function __construct()
    {
        if (! function_exists('opencc_open')) {
            throw new NeedsExtensionException('OpenCC Needs The opencc4php Extension.');
        }
    }

    /**
     * Transform text.
     *
     * @param  string  $text
     * @param  string|null  $configName
     * @return string
     */
    public function trans($text, $configName = null)
    {
        $configName = $this->configName($configName ?: config('opencc.default'));

        if (! isset($this->odMap[$configName])) {
            $this->odMap[$configName] = opencc_open($configName);
        }

        ['in' => $replaceInMap, 'out' => $replaceOutMap] = $this->replaceMap($configName);

        return $this->replaceOut(
            opencc_convert($this->replaceIn($text, $replaceInMap), $this->odMap[$configName]),
            $replaceOutMap
        );
    }

    /**
     * Get replace Map.
     *
     * @param  string  $configName
     * @return array
     */
    protected function replaceMap($configName)
    {
        $index = 0;
        $replaceMap = [
            'in' => [],
            'out' => [],
        ];

        foreach (Arr::get(config("opencc.replace"), $configName) as $in => $out) {
            $key = '${opencc-'.$index++.'}';

            $replaceMap['in'][$key] = $in;
            $replaceMap['out'][$key] = $out;
        }

        return $replaceMap;
    }

    /**
     * Get input replacement text.
     *
     * @param  string  $text
     * @param  array  $replaceMap
     * @return string
     */
    protected function replaceIn($text, array $replaceMap)
    {
        return $replaceMap ? str_replace(array_values($replaceMap), array_keys($replaceMap), $text) : $text;
    }

    /**
     * Get output replacement text.
     *
     * @param  string  $text
     * @param  array  $replaceMap
     * @return string
     */
    protected function replaceOut($text, array $replaceMap)
    {
        return $replaceMap ? str_replace(array_keys($replaceMap), array_values($replaceMap), $text) : $text;
    }

    /**
     * Get Configuration Name.
     *
     * @param  string  $configName
     * @return string
     *
     * @throws \Mvmx\OpenCC\Exceptions\ConfigurationException
     */
    protected function configName($configName)
    {
        $configurations = [
            's2t.json', 't2s.json', 's2tw.json', 'tw2s.json',
            's2hk.json', 'hk2s.json', 's2twp.json', 'tw2sp.json'
        ];

        $configName = Arr::get(config('opencc.aliases'), $configName, $configName);

        if (! in_array($configName, $configurations, true)) {
            throw new ConfigurationException('Invalid Configuration Name.');
        }

        return $configName;
    }

    /**
     * Destruct function
     *
     * @return void
     */
    public function __destruct()
    {
        foreach ($this->odMap as $od) {
            if (is_resource($od)) {
                opencc_close($od);
            }
        }
    }
}
