<!DOCTYPE html>
<html lang="ja">
<style>

  #button {
    width: 200px;
    text-align: center;
  }
  #button a {
    padding: 10px 20px;
    display: block;
    border: 1px solid #2a88bd;
    background-color: #FFFFFF;
    color: #2a88bd;
    text-decoration: none;
    box-shadow: 2px 2px 3px #f5deb3;
  }
  #button a:hover {
    background-color: #2a88bd;
    color: #FFFFFF;
  }
</style>
<body>
<h1>
  パスワード再発行
</h1>
<p>
以下ボタンをクリックしてパスワードを再発行してください。
</p>
<p id="button">
  <a href="{{$reset_url}}">パスワードリセット</a>
</p>
</body>
</html>