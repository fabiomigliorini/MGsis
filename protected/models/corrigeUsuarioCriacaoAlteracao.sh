# Corrige Properties 
sed -i 's/Usuario \$codusuariocriacao/Usuario \$UsuarioCriacao/g' $1
sed -i 's/Usuario \$codusuarioalteracao/Usuario \$UsuarioAlteracao/g' $1

# Corrige Relations
sed -i "s/'codusuarioalteracao'\ =>\ array/'UsuarioAlteracao'\ =>\ array/g" $1
sed -i "s/'codusuariocriacao'\ =>\ array/'UsuarioCriacao'\ =>\ array/g" $1

# Corrige Labels
sed -i "s/\ =>\ 'Criacao',/\ =>\ 'Criação',/g" $1
sed -i "s/\ =>\ 'Alteracao',/\ =>\ 'Alteração',/g" $1
sed -i "s/\ =>\ 'Codusuarioalteracao',/\ =>\ 'Usuário Alteração',/g" $1
sed -i "s/\ =>\ 'Codusuariocriacao',/\ =>\ 'Usuário Criação',/g" $1
