import unittest

class TestFileSystem(unittest.TestCase):
    def setUp(self):
        self.fileSystem = FileSystem()

    def test_mkdir(self):
        self.fileSystem.mkdir("documents")
        self.assertIn("documents", [item.getName() for item in self.fileSystem.currentDirectory.getContents()])

    def test_cd(self):
        self.fileSystem.mkdir("documents")
        self.fileSystem.cd("documents")
        self.assertEqual(self.fileSystem.currentDirectory.getName(), "documents")

    def test_cd_parent(self):
        self.fileSystem.mkdir("documents")
        self.fileSystem.cd("documents")
        self.fileSystem.mkdir("subfolder")
        self.fileSystem.cd("..")
        self.assertEqual(self.fileSystem.currentDirectory.getName(), "/")

    def test_ls(self):
        self.fileSystem.mkdir("documents")
        self.fileSystem.cd("documents")
        self.assertEqual(self.fileSystem.ls(), "documents ")

    def test_findDirectory(self):
        self.fileSystem.mkdir("documents")
        self.fileSystem.cd("documents")
        self.fileSystem.mkdir("subfolder")
        self.assertEqual(self.fileSystem.findDirectory("subfolder").getName(), "subfolder")

if __name__ == '__main__':
    unittest.main()
