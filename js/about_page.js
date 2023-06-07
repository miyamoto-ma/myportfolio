'use strict';

{
    /**
     * Chart.jsの設定
     */
    let ctx = document.getElementById("myRadarChart");
    let myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            //データの各項目のラベル(上から時計回り)
            labels: ["HTML5 & CSS3", "JavaScript", "PHP", "Ruby", "Java", "SQL"],
            //データ設定
            datasets: [
                {
                    //グラフのデータ(上から時計回り)
                    data: [3.5, 4, 3.5, 3, 2.5, 3],
                    //グラフ全体のラベル
                    label: "Skills",
                    //背景色
                    backgroundColor: "rgba(247,249,182,0.5)",
                    //線の終端を四角にするか丸めるかの設定。デフォルトは四角(butt)。
                    borderCapStyle: "butt",
                    //線の色
                    borderColor: "rgba(200,200, 0,0.7)",
                    //線を破線にする
                    borderDash: [],
                    //破線のオフセット(基準点からの距離)
                    borderDashOffset: 0.0,
                    //線と線が交わる箇所のスタイル。初期値は'miter'
                    borderJoinStyle: 'miter',
                    //線の幅。ピクセル単位で指定。初期値は3。
                    borderWidth: 1,
                    //グラフを塗りつぶすかどうか。初期値はtrue。falseにすると枠線だけのグラフになります。
                    fill: true,
                    //複数のグラフを重ねて描画する際の重なりを設定する。z-indexみたいなもの。初期値は0。
                    order: 0,
                    //0より大きい値にすると「ベジェ曲線」という数式で曲線のグラフになります。初期値は0。
                    lineTension: 0
                }
            ]
        },
        options: {
            scales: {
                r: {
                    //グラフの最小値・最大値
                    min: 0,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    },
                    //背景色
                    backgroundColor: 'rgba(226, 250, 246, 0.5)',
                    //グリッドライン
                    grid: {
                        color: '#b6f9ee',
                    },
                    //アングルライン
                    angleLines: {
                        color: '#93c7be',
                    },
                    //各項目のラベル
                    pointLabels: {
                        color: '#5d847d',
                    },
                },
            },
        },
    });


    /**
     * 画像のインナーのbox-shadowのサイズを調整
     */
    const shadow = document.getElementById('shadow');
    const img = shadow.children[0];
    function adjust_height() {
        let img_height = img.clientHeight;
        shadow.style.height = img_height + 'px';
    }
    window.addEventListener('load', () => { adjust_height(); });
    window.addEventListener('resize', () => { adjust_height(); });
}
