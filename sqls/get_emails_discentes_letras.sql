SELECT DISTINCT l.codema FROM LOCALIZAPESSOA l
    JOIN SITALUNOATIVOGR s
    ON s.codpes = l.codpes 
    WHERE l.tipvin = 'ALUNOGR' 
        AND l.codundclg = 8 
        AND s.codcur IN (8050, 8051, 8060)



 