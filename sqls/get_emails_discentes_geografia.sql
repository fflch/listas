SELECT DISTINCT l.codema FROM LOCALIZAPESSOA l
    JOIN SITALUNOATIVOGR s
    ON s.codpes = l.codpes 
    WHERE l.tipvin = 'ALUNOGR' 
        AND l.codundclg = 8 
        AND s.codcur = 8021