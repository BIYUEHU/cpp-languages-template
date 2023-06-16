function snow() {
    //  1、定义一片雪花模板
    var flake = document.createElement("div");
    // 雪花字符 ❄❉❅❆✻✼❇❈❊✥✺
    flake.innerHTML = "❆";
    flake.style.cssText = "position:absolute;color:#fff;";

    //获取页面的高度 相当于雪花下落结束时Y轴的位置
    var documentHieght = window.innerHeight;
    //获取页面的宽度，利用这个数来算出，雪花开始时left的值
    var documentWidth = window.innerWidth;

    //定义生成一片雪花的毫秒数
    var millisec = 100;
    //2、设置第一个定时器，周期性定时器，每隔一段时间（millisec）生成一片雪花；
    setInterval(function () {
        //页面加载之后，定时器就开始工作
        //随机生成雪花下落 开始 时left的值，相当于开始时X轴的位置
        var startLeft = Math.random() * documentWidth;

        //随机生成雪花下落 结束 时left的值，相当于结束时X轴的位置
        var endLeft = Math.random() * documentWidth;

        //随机生成雪花大小
        var flakeSize = 5 + 20 * Math.random();

        //随机生成雪花下落持续时间
        var durationTime = 4000 + 7000 * Math.random();

        //随机生成雪花下落 开始 时的透明度
        var startOpacity = 0.7 + 0.3 * Math.random();

        //随机生成雪花下落 结束 时的透明度
        var endOpacity = 0.2 + 0.2 * Math.random();

        //克隆一个雪花模板
        var cloneFlake = flake.cloneNode(true);

        //第一次修改样式，定义克隆出来的雪花的样式
        cloneFlake.style.cssText += `
                        left: ${startLeft}px;
                        opacity: ${startOpacity};
                        font-size:${flakeSize}px;
                        top:-25px;
                            transition:${durationTime}ms;
                    `;

        //拼接到页面中
        document.body.appendChild(cloneFlake);

        //设置第二个定时器，一次性定时器，
        //当第一个定时器生成雪花，并在页面上渲染出来后，修改雪花的样式，让雪花动起来；
        setTimeout(function () {
            //第二次修改样式
            cloneFlake.style.cssText += `
                                left: ${endLeft}px;
                                top:${documentHieght}px;
                                opacity:${endOpacity};
                            `;

            //4、设置第三个定时器，当雪花落下后，删除雪花。
            setTimeout(function () {
                cloneFlake.remove();
            }, durationTime);
        }, 0);
    }, millisec);
}
snow();
// MorphSVGPlugin.convertToPath("polygon");
var xmlns = "http://www.w3.org/2000/svg",
    xlinkns = "http://www.w3.org/1999/xlink",
    select = function (s) {
        return document.querySelector(s);
    },
    selectAll = function (s) {
        return document.querySelectorAll(s);
    },
    pContainer = select(".pContainer"),
    mainSVG = select(".mainSVG"),
    star = select("#star"),
    sparkle = select(".sparkle"),
    tree = select("#tree"),
    showParticle = true,
    particleColorArray = [
        "#E8F6F8",
        "#ACE8F8",
        "#F6FBFE",
        "#A2CBDC",
        "#B74551",
        "#5DBA72",
        "#910B28",
        "#910B28",
        "#446D39",
    ],
    particleTypeArray = ["#star", "#circ", "#cross", "#heart"],
    // particleTypeArray = ['#star'],
    particlePool = [],
    particleCount = 0,
    numParticles = 201;

// gsap动画库
gsap.set("svg", {
    visibility: "visible",
});

gsap.set(sparkle, {
    transformOrigin: "50% 50%",
    y: -100,
});

let getSVGPoints = (path) => {
    let arr = [];
    var rawPath = MotionPathPlugin.getRawPath(path)[0];
    rawPath.forEach((el, value) => {
        let obj = {};
        obj.x = rawPath[value * 2];
        obj.y = rawPath[value * 2 + 1];
        if (value % 2) {
            arr.push(obj);
        }
        //console.log(value)
    });

    return arr;
};
let treePath = getSVGPoints(".treePath");

var treeBottomPath = getSVGPoints(".treeBottomPath");

//console.log(starPath.length)
var mainTl = gsap.timeline({ delay: 0, repeat: 0 }),
    starTl;

//tl.seek(100).timeScale(1.82)

function flicker(p) {
    //console.log("flivker")
    gsap.killTweensOf(p, { opacity: true });
    gsap.fromTo(
        p,
        {
            opacity: 1,
        },
        {
            duration: 0.07,
            opacity: Math.random(),
            repeat: -1,
        }
    );
}

function createParticles() {
    //var step = numParticles/starPath.length;
    //console.log(starPath.length)
    var i = numParticles,
        p,
        particleTl,
        step = numParticles / treePath.length,
        pos;
    while (--i > -1) {
        p = select(particleTypeArray[i % particleTypeArray.length]).cloneNode(
            true
        );
        mainSVG.appendChild(p);
        p.setAttribute(
            "fill",
            particleColorArray[i % particleColorArray.length]
        );
        p.setAttribute("class", "particle");
        particlePool.push(p);
        //hide them initially
        gsap.set(p, {
            x: -100,
            y: -100,
            transformOrigin: "50% 50%",
        });
    }
}

var getScale = gsap.utils.random(0.5, 3, 0.001, true); //  圣诞树开始绘画时小光点动画的特效（参数：最小值，最大值，延迟）

function playParticle(p) {
    if (!showParticle) {
        return;
    }
    var p = particlePool[particleCount];
    gsap.set(p, {
        x: gsap.getProperty(".pContainer", "x"),
        y: gsap.getProperty(".pContainer", "y"),
        scale: getScale(),
    });
    var tl = gsap.timeline();
    tl.to(p, {
        duration: gsap.utils.random(0.61, 6),
        physics2D: {
            velocity: gsap.utils.random(-23, 23),
            angle: gsap.utils.random(-180, 180),
            gravity: gsap.utils.random(-6, 50),
        },
        scale: 0,
        rotation: gsap.utils.random(-123, 360),
        ease: "power1",
        onStart: flicker,
        onStartParams: [p],
        //repeat:-1,
        onRepeat: (p) => {
            gsap.set(p, {
                scale: getScale(),
            });
        },
        onRepeatParams: [p],
    });

    //
    //particlePool[particleCount].play();
    particleCount++;
    //mainTl.add(tl, i / 1.3)
    particleCount = particleCount >= numParticles ? 0 : particleCount;
}
// 圣诞树开始绘画时小光点动画
function drawStar() {
    starTl = gsap.timeline({ onUpdate: playParticle });
    starTl
        .to(".pContainer, .sparkle", {
            duration: 6,
            motionPath: {
                path: ".treePath",
                autoRotate: false,
            },
            ease: "linear",
        })
        .to(".pContainer, .sparkle", {
            duration: 1,
            onStart: function () {
                showParticle = false;
            },
            x: treeBottomPath[0].x,
            y: treeBottomPath[0].y,
        })
        .to(
            ".pContainer, .sparkle",
            {
                duration: 2,
                onStart: function () {
                    showParticle = true;
                },
                motionPath: {
                    path: ".treeBottomPath",
                    autoRotate: false,
                },
                ease: "linear",
            },
            "-=0"
        )
        // 圣诞树中间那条横线动画   .treeBottomMask  是绑定class='treeBottomMask'这个标签
        .from(
            ".treeBottomMask",
            {
                duration: 2,
                drawSVG: "0% 0%",
                stroke: "#FFF",
                ease: "linear",
            },
            "-=2"
        );

    //gsap.staggerTo(particlePool, 2, {})
}
;
//ScrubGSAPTimeline(mainTl)

function drawMain() {

    mainTl
        // 圣诞树上半身轮廓动画
        .from([".treePathMask", ".treePotMask"], {
            duration: 6,
            drawSVG: "0% 0%",
            stroke: "#FFF",
            stagger: {
                each: 6,
            },
            duration: gsap.utils.wrap([6, 1, 2]),
            ease: "linear",
        })
        //  圣诞树头上的星星动画
        .from(
            ".treeStar",
            {
                duration: 3,
                //skewY:270,
                scaleY: 0,
                scaleX: 0.15,
                transformOrigin: "50% 50%",
                ease: "elastic(1,0.5)",
            },
            "-=4"
        )
        // 当绘画圣诞树的小光点绘制完时，让小光点消失
        .to(
            ".sparkle",
            {
                duration: 3,
                opacity: 0,
                ease: "rough({strength: 2, points: 100, template: linear, taper: both, randomize: true, clamp: false})",
            },
            "-=0"
        )
        // 给圣诞树头上的星星加个白色特效
        .to(
            ".treeStarOutline",
            {
                duration: 1,
                opacity: 0.3,
                ease: "rough({strength: 2, points: 16, template: linear, taper: none, randomize: true, clamp: false})",
            },
            "+=1"
        );
    /* .to('.whole', {
    opacity: 0
    }, '+=2') */
}



function drawStars() {
    let canvas = document.getElementById("stars"),
        ctx = canvas.getContext("2d"),
        w = (canvas.width = window.innerWidth),
        h = (canvas.height = window.innerHeight),
        hue = 37, //色调色彩
        stars = [], //保存所有星星
        count = 0, //用于计算星星
        maxStars = 1300; //星星数量

    //canvas2是用来创建星星的源图像，即母版，
    //根据星星自身属性的大小来设置
    var canvas2 = document.createElement("canvas"),
        ctx2 = canvas2.getContext("2d");
    canvas2.width = 100;
    canvas2.height = 100;
    //创建径向渐变，从坐标(half，half)半径为0的圆开始，
    //到坐标为(half,half)半径为half的圆结束
    var half = canvas2.width / 2,
        gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
    gradient2.addColorStop(0.025, "#CCC");
    //hsl是另一种颜色的表示方式，
    //h->hue,代表色调色彩，0为red，120为green，240为blue
    //s->saturation，代表饱和度，0%-100%
    //l->lightness，代表亮度，0%为black，100%位white
    gradient2.addColorStop(0.1, "hsl(" + hue + ", 61%, 10%)");
    gradient2.addColorStop(0.25, "hsl(" + hue + ", 64%, 2%)");
    gradient2.addColorStop(1, "transparent");

    ctx2.fillStyle = gradient2;
    ctx2.beginPath();
    ctx2.arc(half, half, half, 0, Math.PI * 2);
    ctx2.fill();

    // End cache
    function random(min, max) {
        if (arguments.length < 2) {
            max = min;
            min = 0;
        }

        if (min > max) {
            var hold = max;
            max = min;
            min = hold;
        }

        //返回min和max之间的一个随机值
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function maxOrbit(x, y) {
        var max = Math.max(x, y),
            diameter = Math.round(Math.sqrt(max * max + max * max));
        //星星移动范围，值越大范围越小，
        return diameter / 2;
    }

    var Star = function () {
        //星星移动的半径
        this.orbitRadius = random(maxOrbit(w, h));
        //星星大小，半径越小，星星也越小，即外面的星星会比较大
        this.radius = random(60, this.orbitRadius) / 8;
        //所有星星都是以屏幕的中心为圆心
        this.orbitX = w / 2;
        this.orbitY = h / 2;
        //星星在旋转圆圈位置的角度,每次增加speed值的角度
        //利用正弦余弦算出真正的x、y位置
        this.timePassed = random(0, maxStars);
        //星星移动速度
        this.speed = random(this.orbitRadius) / 50000;
        //星星图像的透明度
        this.alpha = random(2, 10) / 10;

        count++;
        stars[count] = this;
    };

    Star.prototype.draw = function () {
        //星星围绕在以屏幕中心为圆心，半径为orbitRadius的圆旋转
        var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
            y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
            twinkle = random(10);

        //星星每次移动会有1/10的几率变亮或者变暗
        if (twinkle === 1 && this.alpha > 0) {
            //透明度降低，变暗
            this.alpha -= 0.05;
        } else if (twinkle === 2 && this.alpha < 1) {
            //透明度升高，变亮
            this.alpha += 0.05;
        }

        ctx.globalAlpha = this.alpha;
        //使用canvas2作为源图像来创建星星，
        //位置在x - this.radius / 2, y - this.radius / 2
        //大小为 this.radius
        ctx.drawImage(
            canvas2,
            x - this.radius / 2,
            y - this.radius / 2,
            this.radius,
            this.radius
        );
        //没旋转一次，角度就会增加
        this.timePassed += this.speed;
    };

    //初始化所有星星
    for (var i = 0; i < maxStars; i++) {
        new Star();
    }

    function animation() {
        //以新图像覆盖已有图像的方式进行绘制背景颜色
        ctx.globalCompositeOperation = "source-over";
        ctx.globalAlpha = 0.9; //尾巴
        ctx.fillStyle = "hsla(" + hue + ", 64%, 6%, 2)";
        ctx.fillRect(0, 0, w, h);

        //源图像和目标图像同时显示，重叠部分叠加颜色效果
        ctx.globalCompositeOperation = "lighter";
        for (var i = 1, l = stars.length; i < l; i++) {
            stars[i].draw();
        }

        //调用该方法执行动画，并且在重绘的时候调用指定的函数来更新动画
        //回调的次数通常是每秒60次
        window.requestAnimationFrame(animation);
    }

    animation();
}


let myLabels = msg;

function init() {
    let element = document.getElementById("header");
    for (let i = 0; i < myLabels.length; i++) {
        let _p = document.createElement("p");
        _p.className = "header-item";
        _p.innerHTML = myLabels[i];
        element.appendChild(_p);
    }

    let labels = document.getElementsByClassName('header-item');
    for (let i = 0; i < myLabels.length; i++) {
        setTimeout(() => {
            labels[i].classList.add("show");
        }, 1000 * i);
    }
}
let init_flag = false;
// music
let music_url = music;
let _music = new Audio(music_url);
window.onclick = function () {
    if (init_flag) return;
    init_flag = true;
    _music.play();
    init();
    let mask = document.getElementById("mask");
    mask.remove();
    createParticles()
    drawStar();
    drawMain();
    mainTl.add(starTl, 0);
    gsap.globalTimeline.timeScale(1.5); //  圣诞树开始绘画时小光点动画的绘画速率，越大越快
    drawStars();
}