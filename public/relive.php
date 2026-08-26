<?php
header('Content-Type: text/html; charset=utf-8');

// ==================== 配置 ====================
$DATA_FILE = __DIR__ . '/relive_data.json';

// 确保文件存在
if (!file_exists($DATA_FILE)) {
    file_put_contents($DATA_FILE, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// ==================== 路由处理 ====================
$method = $_SERVER['REQUEST_METHOD'];
$is_api  = isset($_GET['api']) && $_GET['api'] === 'count';

if ($method === 'GET' && $is_api) {
    // GET ?api=count → 返回记录条数
    $data = json_decode(file_get_contents($DATA_FILE), true) ?: [];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['count' => count($data)], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method === 'POST') {
    // 处理留言提交
    header('Content-Type: application/json; charset=utf-8');

    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);

    $message = trim($input['message'] ?? '');
    if (strlen($message) > 300) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'msg' => '内容长度应为0~300字']);
        exit;
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    // 简单防刷：同一IP只能留一次言（可按需改成按天/小时限制）
    $data = json_decode(file_get_contents($DATA_FILE), true) ?: [];

    foreach ($data as $item) {
        if ($item['ip'] === $ip) {
            http_response_code(429);
            echo json_encode(['ok' => false, 'msg' => '你已经留言过了']);
            exit;
        }
    }

    $new_record = [
        'ip'      => $ip,
        'content' => $message,
        'time'    => date('Y-m-d H:i:s'),
        'timestamp' => time(),
    ];

    $data[] = $new_record;
    $success = file_put_contents($DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode([
        'ok'  => $success !== false,
        'msg' => $success !== false ? '留言成功' : '写入失败'
    ]);
    exit;
}

// ==================== 普通GET → 显示页面 ====================
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relive - 复活吧！</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
  <style>
    :root {
      --primary: #6366f1;
    }
    body {
      max-width: 640px;
      margin: 2rem auto;
      padding: 0 1rem;
    }
    .math-box {
      font-size: 1.4rem;
      font-weight: bold;
      margin: 1.5rem 0;
      padding: 1rem;
      background: #f1f5f9;
      border-radius: 8px;
      text-align: center;
    }
    .hidden { display: none; }
    #msg { min-height: 6rem; resize: vertical; }
    footer { margin-top: 3rem; text-align: center; color: #64748b; font-size: 0.9rem; }
  </style>
</head>
<body>

<main>
  <h1>Relive</h1>
  <p>复活吧！HotaruAPI！</p>

  <div class="math-box" id="mathQuestion"></div>

  <form id="form">
    <label for="answer">答案：</label>
    <input type="number" id="answer" required autocomplete="off">

    <label for="msg">留言内容（可选，最多300字）：</label>
    <textarea id="msg" maxlength="300"></textarea>

    <button type="submit" class="contrast" id="submitBtn">提交</button>
  </form>

  <p id="result" class="hidden"></p>
</main>

<footer>
  <small>当前应援人数：<span id="count">加载中...</span></small>
</footer>

<script>
// ==================== 生成简单算术题 ====================
function generateMathProblem() {
  const a = Math.floor(Math.random() * 40) + 10;
  const b = Math.floor(Math.random() * 30) + 5;
  const ops = ['+', '-', '×'];
  const op = ops[Math.floor(Math.random() * ops.length)];

  let question = `${a} ${op} ${b} = ?`;
  let answer;

  if (op === '+') answer = a + b;
  else if (op === '-') answer = a - b;
  else answer = a * b;

  return { question, answer };
}

const problem = generateMathProblem();
document.getElementById('mathQuestion').textContent = problem.question;
const correctAnswer = problem.answer;

// ==================== 获取留言数量 ====================
fetch('?api=count')
  .then(r => r.json())
  .then(d => {
    document.getElementById('count').textContent = d.count;
  })
  .catch(() => {
    document.getElementById('count').textContent = '获取失败';
  });

// ==================== 提交逻辑 ====================
document.getElementById('form').addEventListener('submit', async e => {
  e.preventDefault();

  const userAnswer = parseInt(document.getElementById('answer').value);
  const message = document.getElementById('msg').value.trim() || "";

  const resultEl = document.getElementById('result');
  resultEl.classList.remove('hidden');

  if (userAnswer !== correctAnswer) {
    resultEl.textContent = '答案错误';
    resultEl.style.color = 'var(--red-600)';
    return;
  }

//   if (!message) {
//     resultEl.textContent = '留言内容不能为空';
//     resultEl.style.color = 'var(--red-600)';
//     return;
//   }

  try {
    const resp = await fetch('', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ message })
    });

    const data = await resp.json();

    if (data.ok) {
      resultEl.textContent = '应援成功！';
      resultEl.style.color = 'var(--green-600)';
      document.getElementById('form').reset();
      // 可选：刷新计数
      fetch('?api=count').then(r=>r.json()).then(d=>{
        document.getElementById('count').textContent = d.count;
      });
    } else {
      resultEl.textContent = data.msg || '提交失败';
      resultEl.style.color = 'var(--red-600)';
    }
  } catch (err) {
    resultEl.textContent = '网络错误，请稍后再试';
    resultEl.style.color = 'var(--red-600)';
  }
});
</script>

</body>
</html>