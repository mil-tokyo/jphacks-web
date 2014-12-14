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

		$queue = \Model_Queue::find($queue_id);
		if ( ! $queue) {
			$this->response(array('stat'=>0, 'msg' => 'No queue match'));
			return;
		}

		if ( ! $queue->result) {
			$this->response(array('stat'=>-1, 'msg' => 'Running'));
			return;
		}

		if ( ! $queue->result->json) {
			$this->response(array('stat'=>0, 'msg' => 'Error: invalid result'));
			return;
		}

		$result['stat'] = 1;
		$result['result'] = json_decode($queue->result->json);
		// mock
		/*
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
		*/

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
//		$res_label = array();
//		$res_data = array();
		$res = array();
  // ファイルポインタを開く
		$fp = fopen( $path, 'r' );

  // データが無くなるまでファイル(CSV)を１行ずつ読み込む
		while( $ret_csv = fgetcsv( $fp, 256 ) ) {
			$row = array();
			$row[0] = (int)$ret_csv[0];
			for($i = 1; $i < count( $ret_csv ); ++$i ){
				$row[$i] = (float)$ret_csv[$i];
			}
			$res[] = $row;
			/*
			$res_label[] = (int)$ret_csv[0];

			$row = array();
			for($i = 1; $i < count( $ret_csv ); ++$i ){
				$row[$i-1] = (float)$ret_csv[$i];
			}
			$res_data[] = $row;
			*/
		}

  // 開いたファイルポインタを閉じる
		fclose( $fp );
		return array('data' => $res);
		/*
		return array(
			'data' => $res_data,
			'label' => $res_label,
		);
		*/
	}
}