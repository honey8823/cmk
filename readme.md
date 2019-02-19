* Smarty,AdminLTEについて
	* 以下ディレクトリ構造にて使用していますが、リポジトリには含んでいません
		* src/app/libs/smarty-3.1.33/
		* src/public/libs/adminlte-2.4.5/
	* ディレクトリ名や位置を変更する場合、```src/config/application.ini.php``` 内の定義を合わせて変更してください
* データベース構造について
	* ```db_schema``` ディレクトリに構築用クエリが存在します
		* ただし最新版とは限りません。開発中の変更はissue内で管理しており、大きめのリリースの時に構築用クエリも更新しています