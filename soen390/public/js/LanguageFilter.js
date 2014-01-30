var previousLanguage = "";

function toggleLanguages(language)
{
    //We want to unhide the currently hidden language
    if (language == previousLanguage)
    {
        setCardOpacity("");
        previousLanguage = "";
    }

    //We want to hide a new language
    else
    {
        setCardOpacity(language);
        previousLanguage = language;
    }
}

function setCardOpacity(language) 
{
    rectangles.transition()
              .duration(1000)
              .style('opacity', function (d) { return changeOpacity(d, language); });
}

function changeOpacity(d, language)
{
    if (language != d.language)
        return 1;
    
    else
        return 0.2;
}