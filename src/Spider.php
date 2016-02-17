<?php 

/**
* Spider
* 
* Responsible for crawling the paths and gathering information
*/
class Spider
{
    protected $path;
    protected $response;
    protected $result;

    function __construct(ResponseContract $response)
    {
        $this->path = new Path();
        $this->response = $response;
        $this->result = '';
    }

    public function crawlPath($path, $resultPath = '') {

        $this->path->setPath($path);
        $this->path->validate();

        $result = [];
        $this->probePath($path, $result);

        $this->result = $this->response->format($result);

        // If the result path is provided, data will be saved as well
        if (!empty($resultPath)) {
            $this->path->setPath($resultPath);
            $this->path->saveContent($this->result);
        }

        return $this->result;
    }

    public function probePath($path, &$parentItem, $fullPath = '') {

        if (empty($fullPath)) {
            $fullPath = $path;
        }

        $this->path->setPath($fullPath);
        $parentItem[$path] = $this->path->getDetail();
        
        if ($this->path->getType() === 'dir') {
            // Recursively iterate the directory and find the inner contents
            $handle = opendir($fullPath);

            while($content = readdir($handle)) {
                if ( $content == '.' || $content == '..') {
                    continue;
                }

                $this->probePath($content, $parentItem[$path],  $fullPath . '/' .$content);
            };
        }
    }

    private function getDirectoryContent( $path ) {

        $this->path->setPath($path);
        $this->path->validate();

        $content = $this->path->getContent();

        $result = $this->response->toArray($content);

        if (empty($result)) {
            throw new NoContentException("The file ' . $path . ' has no content", 1);
        } else if (!is_array($result)) {
            throw new InvalidContentException("The content in file " . $path . " could not be processed", 1);            
        }

        return $result;
    }

    public function populatePath($outputDir, $sourcePath, $content = [], $isRecursive = false) {

        if ( $isRecursive === false ) {
            $content = $this->getDirectoryContent($sourcePath);
        }

        if (!is_dir($outputDir)) {
            $this->path->setPath($outputDir);
            $this->path->createItem();
        }

        foreach ($content as $label => $detail) {

            // if it is a property
            if ( $label[0] === '-') {
                continue;
            }

            $toCreate = $outputDir . '/' . $label;

            if (!file_exists($toCreate)) {
                $this->path->setPath($toCreate);
                $this->path->createItem($detail);
            }

            if (empty($detail['-type']) || ($detail['-type'] == 'dir')) {
                $this->populatePath($toCreate, '', $detail);
            }
        }
    }

}