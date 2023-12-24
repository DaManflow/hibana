package expression;

public class Nombre extends Expression
{
	

	private int valeurNombre ; // Entier encapsulé


	public Nombre(int uneValeur)
	{
		super() ;
		this.valeurNombre = uneValeur ;
	}

	public int valeur()
	{
		return this.valeurNombre ;
	}


	public String toString()
	{
		return Integer.toString(this.valeurNombre) ;
	}
	
}
