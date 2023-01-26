# Description

This is a single page application (SPA) built using vanilla php and javascrpt

I built this project while I was learning fundamentals of web technologies like javascri;t, php , mysql

Demo: http://mimicly.rf.gd

The main motive was to build my own SPA Router utilizing browser's History API

Though this spa router is not good, it is functional. Its features and my logic:

- navigation between pages is extremely fast
- state management of all pages
- each page lies inside different html 'div'
- each div is given a key equal to url shown on browser's address bar
- So, when viewing a page, all other divs are hidden
- animations during page transitions
- scroll control - E.g. suppose you were viewing post of user A in home feed, then you wished to view porifile of A. You visited A's profile and clicked back button. Then you will be redirected to the point where you left off before visiting A's profile
- ...

# file containing my SPA router logic

https://github.com/arjun703/Mimicly/blob/main/htdocs/updatediv.js