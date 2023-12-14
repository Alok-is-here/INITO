<?php 
class FileSystem 
{ 
    private $currentDirectory; 
    private $rootDirectory; 
 
    public function __construct() 
    { 
        $this->rootDirectory = new MyDirectory("/"); 
        $this->currentDirectory = $this->rootDirectory; 
    } 
 
    public function mkdir($name) 
    { 
        $directory = new MyDirectory($name); 
        $this->currentDirectory->add($directory); 
    } 
 
    public function cd($path) 
    { 
        if ($path === "..") { 
            $this->currentDirectory = $this->currentDirectory->getParent(); 
        } elseif ($path === "/") { 
            $this->currentDirectory = $this->rootDirectory; 
        } else { 
            $directory = $this->findDirectory($path); 
            if ($directory) { 
                $this->currentDirectory = $directory; 
            } else { 
                echo "Directory not found.\n"; 
            } 
        } 
    } 
 
    public function ls($path = "") 
    { 
        $directory = $path ? $this->findDirectory($path) : $this->currentDirectory; 
        if ($directory) { 
            $directory->listContents(); 
        } else { 
            echo "Directory not found.\n"; 
        } 
    } 
 
    // ... (rest of the code remains unchanged) 
 
    private function findDirectory($path) 
    { 
        $currentDirectory = $this->currentDirectory; 
        $pathSegments = explode("/", $path); 
 
        foreach ($pathSegments as $segment) { 
            if ($segment === "..") { 
                $currentDirectory = $currentDirectory->getParent(); 
            } else { 
                $found = false; 
                foreach ($currentDirectory->getContents() as $item) { 
                    if ($item instanceof MyDirectory && $item->getName() === $segment) { 
                        $currentDirectory = $item; 
                        $found = true; 
                        break; 
                    } 
                } 
 
                if (!$found) { 
                    return null; // Directory not found 
                } 
            } 
        } 
 
        return $currentDirectory; 
    } 
} 
 
class MyDirectory 
{ 
    private $name; 
    private $parent; 
    private $contents; 
 
    public function __construct($name, $parent = null) 
    { 
        $this->name = $name; 
        $this->parent = $parent; 
        $this->contents = []; 
    } 
 
    public function add($item) 
    { 
        $this->contents[] = $item; 
        if ($item instanceof MyDirectory) { 
            $item->setParent($this); 
        } 
    } 
 
    public function listContents() 
    { 
        foreach ($this->contents as $item) { 
            echo $item->getName() . " "; 
        } 
        echo "\n"; 
    } 
 
    public function getName() 
    { 
        return $this->name; 
    } 
 
    public function getParent() 
    { 
        return $this->parent; 
    } 
 
    public function setParent($parent) 
    { 
        $this->parent = $parent; 
    } 
 
    public function getContents() 
    { 
        return $this->contents; 
    } 
} 
 
class File 
{ 
    // ... (rest of the code remains unchanged) 
} 
 
// Example Usage: 
$fileSystem = new FileSystem(); 
 
// Create directories and files 
$fileSystem->mkdir("documents"); 
$fileSystem->mkdir("pictures"); 
$fileSystem->cd("documents"); 
$fileSystem->ls(); // Output: (empty) 
?>
