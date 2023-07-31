<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\{Config, File};
class LanguageController extends Controller {
    public function index() {
        $languages = collect(config('laravellocalization.supportedLocales'))->sortByDesc('status')->all();
        return view('dashboard.settings.languages.index', ['title'=>'Languages', 'languages'=>$languages]);
    }

    // Update Language Status
    public function update($key) {
        $languages = config('laravellocalization.supportedLocales');
        $languages[$key]['status'] = !$languages[$key]['status'];
        config(['laravellocalization.supportedLocales.' . $key . '.status' => $languages[$key]['status']]);
        $save = file_put_contents(config_path('laravellocalization.php'), '<?php return ' . var_export(config('laravellocalization'), true) . ';');
        if ($save) {
            if (file_exists(base_path('lang' . DIRECTORY_SEPARATOR . $key)) == false)
                mkdir(base_path('lang' . DIRECTORY_SEPARATOR . $key), 0777, true);
            return redirect()->route('languages.index')->with('success', 'Language status updated successfully');
        } else {
            return redirect()->route('languages.index')->with('error', 'Failed to update language status');
        }
    }

    // Check Language Directory
    public function checkLanguageDirectory($key) {
        $this->copyLangTranslationFiles($key);
        return redirect()->route('languages.index')->with('success', 'Language directory created successfully');
    }

    public function copyLangTranslationFiles($key) {
        $defaultLanguage = Config::get('app.locale');
        $sourcePath = base_path('lang/' . $defaultLanguage);
        $destinationPath = base_path('lang/' . $key);
        if (file_exists($destinationPath)) {
            File::copyDirectory($sourcePath, $destinationPath);
            $files = File::allFiles($destinationPath);
            foreach ($files as $file) {
                $content = file_get_contents($file);
                $content = preg_replace('/\'(.+?)\'\s*=>\s*\'(.+?)\',?/', '\'\1\' => \'\',', $content);
                file_put_contents($file, $content);
            }
            
        }
        $this->translateLanguageFiles($key);
    }
    
    public function translateLanguageFiles($key) {
        $files = File::allFiles(base_path('lang/' . Config::get('app.locale')));
        foreach ($files as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $translations = Lang::get($fileName);

            if (array_key_exists($key, $translations)) {
                $value = $translations[$key];
                $translatedValue = $this->translateText($value, $key, 'ar', Config::get('myMemory.my_memory_api_key'));

                foreach (config('app.locales') as $locale) {
                    if ($locale !== Config::get('app.locale')) {
                        $translatedTranslations = Lang::get($fileName, [], $locale);
                        $translatedTranslations[$key] = $translatedValue;
                        $langFilePath = base_path('lang/' . $locale . '/' . $fileName . '.php');
                        $content = "<?php\n\nreturn " . var_export($translatedTranslations, true) . ";\n";
                        file_put_contents($langFilePath, $content);
                        $lang = Lang::getLoader()->load($locale, $fileName);
                        $lang[$key] = $translatedValue;
                        Lang::addLines($lang, $locale, $fileName);

                    }
                }
            }
        }
    }
}
