SELECT nome, quantidade FROM componentes INNER JOIN itens ON componentes.idcomponentes = itens.componentes_iditens
ORDER BY componentes.nome;
