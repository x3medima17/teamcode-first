#include <stdio.h>
#include <conio.h>

FILE *in,*out;
int a[64][64],i,j,k=0,n;

int sum(int l, int x, int y)
{
    int s;
    for(i=y;i>y-l;i--)
    {
                    for(j=x;j<x+l-1;j++)
                    {
                                    s+=a[i][j];
                                    }
                    }
    return s;
    }

void f(int l, int x, int y)
{
     if(sum(l,x,y)==l*l || sum(l,x,y)==0) k+=2;
     else 
     {
          k++;
          f(l/2,x,y);
          f(l/2,x+l/2,y);
          f(l/2,x,y-l/2);
          f(l/2,x+l/2,y-l/2);
          } 
     }
     
int main()
{
    in=fopen("image.in","r");
    fscanf(in,"%d",&n);
    for(i=0;i<n;i++)
    {
                    for(j=0;j<n;j++)
                    {
                                    fscanf(in,"%d",&a[i][j]);
                                    }
                    }
    f(n,0,n-1);
    printf("%d",k);
    getchar();
    }
