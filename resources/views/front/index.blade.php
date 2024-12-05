@extends('front.layouts.app')

@section('content')
    <body class="font-poppins text-[#030303] bg-[#F6F5FA] pb-[100px] px-4 sm:px-0">
    
    <x-nav/>

    <section id="header" class="container max-w-[1130px] mx-auto mt-[50px]">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
            <h1 class="font-extrabold text-[40px] leading-[45px] text-center sm:text-left">Sentimen Analisis</h1>
        </div>
        <div class="flex flex-col sm:flex-row items-center justify-end mt-4">
            <div class="flex flex-col items-end">
                <img src="assets/thumbnails/taksonomi-senlis.png" alt="Taksonomi" width="800" height="400" class="object-contain">
                <div class="flex justify-end w-full">
                    <p class="mt-2"> (Idrisu et al., 2023)</p>
                </div>
            </div>
        </div>
    </section>

    <section id="sentiment-analysis-info" class="container max-w-[1130px] mx-auto mt-[30px]">
        <div class="flex flex-col items-center text-center">
            <p class="text-lg leading-6">
                Sentimen analisis mengacu pada proses Natural Language Processing (NLP) yang mengidentifikasi informasi subjektif yang diungkapkan dalam sebuah teks dan apakah informasi tersebut positif, negatif, atau netral (García-Díaz et al., 2020). 
                Sentimen analisis digunakan untuk mengetahui kecenderungan atau sikap seseorang terhadap suatu topik atau masalah oleh seseorang, apakah lebih cenderung bersifat positif maupun bersifat negatif (Bhavish Khanna et al., 2018).
            </p>
        </div>
    </section>

    </body>
@endsection
