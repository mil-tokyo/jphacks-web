<?php
class Controller_Api extends \Controller_Rest
{
	public function post_request()
	{
		$json = \Input::post('structure');
		$data = json_decode($json);
		if ( ! $data ) {
			$this->response(array('stat' => 0, 'msg' => 'Invalid structure data'));
			return;
		}

		// check if data set
		$input_exist = false;
		foreach ($data as &$elem) {
			if ( isset($elem->data) ){
				$input_exist = true;
				break;
			} else {
				$data_from_file = $this->load_file();
				if ($data_from_file){
					$elem->data = $data_from_file;
					$input_exist = true;
					break;
				}
			}
		}

		if ( ! $input_exist){
			$this->response(array('stat' => 0, 'msg' => 'No data input'));
			return;
		}

		$structure = \Model_Structure::forge();
		$structure->set('json', json_encode($data));

		$queue = \Model_Queue::forge();
		$queue->structure = $structure;

		$queue->save();

		$this->response(array('stat' => 1, 'queue_id' => $queue->id));
	}

	public function get_result()
	{
		$queue_id = \Input::get('queue_id');
		// mock
		$result = array(
			'stat' => 1,
			'result' => array(
				array(
					'type' => 'Visualizer',
					'name' => 'visualizer1',
					'img' => 'imgs/test.jpg'
				),
				array(
					'type' => 'Visualizer',
					'name' => 'visualizer2',
					'img' => 'imgs/test2.jpg'
				)
			)
		);

		$this->response($result);
	}

	private function load_file()
	{
        // 初期設定
        $config = array(
            'path' => APPPATH.DS.'tmp',
            'randomize' => true,
            'ext_whitelist' => array('csv'),
        );
 
        // アップロード基本プロセス実行
        Upload::process($config);
 
        // 検証
        if (Upload::is_valid())
        {
            // 設定を元に保存
            Upload::save();
 
            $fileinfo = Upload::get_files();
            $tmppath = $fileinfo[0]['file'];
            $res = $this->parse_csv($tmppath);
            return $res ?: false;
        }
 
        return false;
	}

	private function parse_csv($path){
		$res = array();
  // ファイルポインタを開く
		$fp = fopen( $path, 'r' );

  // データが無くなるまでファイル(CSV)を１行ずつ読み込む
		while( $ret_csv = fgetcsv( $fp, 256 ) ) {
			$row = array();
			for($i = 0; $i < count( $ret_csv ); ++$i ){
				$row[$i] = (float)$ret_csv[$i];
			}

			$res[] = $row;
		}

  // 開いたファイルポインタを閉じる
		fclose( $fp );
		return $res;
	}
}