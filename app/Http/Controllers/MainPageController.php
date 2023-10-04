<?php
	namespace App\Http\Controllers;

    use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;

	use App\Models\Avtor;
	
	class MainPageController extends Controller
	{
		public function show()
		{
			return view('client.main-page',[
				'title' => 'Головна'
			]);
		}

		// ЛМВ
		public function lmv()
		{
			return view('_hpk.lmv',[
				'title' => 'Щопочитайка'
			]);
		}

		// КПЗ
		public function kpzDialog()
		{
			$rezults = DB::select('SELECT * FROM _rezults');
			$questions = DB::select('SELECT * FROM _questions');
			$answers = DB::select('SELECT * FROM _answers');

			$dividedQuestions = [];
			foreach ($questions as $question) {
				$lineId = $question->line_id;
				$key = ($lineId == '') ? 'line_0' : 'line_' . $lineId;
				$dividedQuestions[$key][] = $question;
			}

			return view('_hpk.kpz-dialog',[
				'title' => 'Щопочитайка',
				'rezults' => $rezults,
				'questions' => $dividedQuestions,
				'answers' => $answers,
			]);
		}
		public function kpzAll()
		{
			$rezults = DB::select('SELECT * FROM _rezults');
			$questions = DB::select('SELECT q.*, r.name as line FROM _questions as q
									LEFT JOIN _rezults as r
									ON r.id = q.line_id
									ORDER BY r.id');
			return view('_hpk.kpz-all',[
				'title' => 'Щопочитайка',
				'rezults' => $rezults,
				'questions' => $questions,
			]);
		}
		public function kpzRezultPost(Request $request)
		{
			$error = '';
			if ($request->input('rezult'))
			try {
				$insertedId = DB::table('_rezults')->insertGetId([
					'name' => $request->input('rezult'),
				]);
			}
			catch (\Exception $e) {
				$error = 'Помилка при вставці даних. ';
			}
			if ($request->input('del_rezult_id'))
			try {
				DB::table('_rezults')->where('id', $request->input('del_rezult_id'))->delete();
			}
			catch (\Exception $e) {
				$error = 'Помилка при видаленні даних. ';
			}
	
			if ($error!='') return redirect()->back()->with('error', $error);
			else return redirect()->back()->with('success', 'Операцію здійснено успішно.');
		}
		public function kpzQuestionForm()
		{
			return view('_hpk.kpz',[
				'title' => 'Щопочитайка'
			]);
		}
		public function kpzQuestionPost(Request $request)
		{
			$error = '';
			if ($request->input('question'))
			try {
				$insertedId = DB::table('_questions')->insertGetId([
					'text' => $request->input('question'),
					'line_id' => $request->input('question_line_id'),
				]);
			}
			catch (\Exception $e) {
				$error = 'Помилка при вставці даних. ';
			}
			if ($request->input('del_question_id'))
			try {
				DB::table('_questions')->where('id', $request->input('del_question_id'))->delete();
			}
			catch (\Exception $e) {
				$error = 'Помилка при видаленні даних. ';
			}
	
			if ($error!='') return redirect()->back()->with('error', $error);
			else return redirect()->back()->with('success', 'Операцію здійснено успішно.');
		}
		public function kpzQuestionEdit(Request $request, $id)
		{
			$question = DB::table('_questions as q')
			->leftJoin('_rezults as r', 'q.line_id', '=', 'r.id')
			->select('q.*', 'r.name as line')
			->where('q.id', $id)
			->first();  
			$rezults = DB::select('SELECT * FROM _rezults'); 
		
			if ($question){
				if ($request->has('submit')){ 
					$error = '';					
					if ($request->input('question_text'))
					try {
						DB::table('_questions')->where('id', $id)->update([
							'text' => $request->input('question_text'),
							'line_id' => $request->input('question_line_id'),
						]);
					}
					catch (Exception $e) {
						$error = 'Помилка при вставці даних. ';
					}
					if ($error!='') return redirect()->back()->with('error', $error);
					else return redirect()->back()->with('success', 'Операцію здійснено успішно.');
				}
				else {    
					$answers = DB::select("SELECT a.*, r.name as rezult FROM _answers as a
											INNER JOIN _rezults as r
											ON r.id = a.r_id
											WHERE a.q_id = $id");    
					return view('_hpk.kpz-form', [
						'title' => 'Щопочитайка - Адмінка',
						'question' => $question,
						'answers' => $answers,
						'rezults' => $rezults,
					]);
				}
			}
		}
		public function kpzAnswerAdd(Request $request, $id)
		{
			$error = '';				
			if ($request->input('answer_text'))
			try {
				$insertedId = DB::table('_answers')->insertGetId([
					'text' => $request->input('answer_text'),
					'q_id' => $id,
					'r_id' => $request->input('answer_rezult_id'),
					'size' => $request->input('answer_size'),
				]);
			}
			catch (\Exception $e) {
				$error = 'Помилка при вставці даних. ';
			}
			$error = '';	
			if ($request->input('del_answer_id'))
			try {
				DB::table('_answers')->where('id', $request->input('del_answer_id'))->delete();
			}
			catch (\Exception $e) {
				$error = 'Помилка при видаленні даних. ';
			}

			if ($error!='') return redirect()->back()->with('error', $error);
			else return redirect()->back()->with('success', 'Зміни внесено успішно.');
		}
	}
?>