@extends('app')

@section('siteTitle')
    Home
@stop
@section('topLeftMenu')

@stop
@section('leftProfile')
<h1>Amaricus</h1>

<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">100</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">1000</button></a>


<p>This is someone's motto, let's see how long it can be
Should be at least 3 lines long by default. Right?</p>
    <hr/>
<h2>Top 3</h2>

<ul>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Testimony of a Toker</button></a></li>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Destiny of Forgiveness</button></a></li>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Where to find God for your journey</button></a></li>
</ul>
<hr/>
    <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
@stop
@section('bottomLeftMenu')

@stop
@section('centerMenu')
    <h2>This is a title</h2>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Elevate: 133 123 120</button></a>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Extend: 103 423 4</button></a>
 <table align = "center" border = "1" style = "margin: 23px auto;">
     <tr><td>Indexer</td><td>Date</td><td>Belief Center</td></tr>
     <tr><td>#Bab</td><td>9/23/2014</td><td>Treacy Levine Center </td></tr>
 </table>
@stop
@section('centerText')
    <hr class = "mainHr">
    <p>Some things in CSS are a bit tedious to write,
        especially with CSS3 and the many vendor prefixes
        that exist. A mixin lets you make groups of CSS
        declarations that you want to reuse throughout your
        site. You can even pass in values to make your mixin
        more flexible. A good use of a mixin is for vendor
        prefixes. Here's an example for border-radius.</p>
    <p>Some things in CSS are a bit tedious to write,
        especially with CSS3 and the many vendor prefixes
        that exist. A mixin lets you make groups of CSS
        declarations that you want to reuse throughout your
        site. You can even pass in values to make your mixin
        more flexible. A good use of a mixin is for vendor
        prefixes. Here's an example for border-radius.</p>
    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.

    </p>
    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.

    </p>
    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.

    </p>



@stop
@section('centerBottom')

@stop
@section('topRightMenu')

@stop
@section('rightProfile')
    <h2>Inspired By:</h2>
    <ul>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">1Dr. Greenthumb</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Majestic</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">TheThoughtAdjuster</button></a></li>
    </ul>
    <hr/>
    <h2>Inspires:</h2>
    <ul>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">WhereartThou?</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">OneLoveLoveLove Love BabyaLone God</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Num1</button></a></li>
    </ul>
    <hr/>
    <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
@stop
@section('bottomRightMenu')

@stop