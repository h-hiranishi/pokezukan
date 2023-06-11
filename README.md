# ポケモン図鑑

## 概要
- 外部API[PokeAPI](https://pokeapi.co/docs/v2)を利用したポケモン図鑑

## 設計
- MVCアーキテクチャ
  - Model: APIとの通信を担当。キャッシュに関する処理もModelの担当。
  - View: ブラウザに表示するプログラムの生成。ユーザからの処理を受け取りその結果を描画する。
  - Controller: 特になし。今後viewの機能からControllerで行ってもよいものを少し分けてあげたい。


